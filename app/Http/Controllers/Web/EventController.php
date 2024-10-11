<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Conference;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Room;
use App\Models\Session;
use App\Models\Ticket;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "eventName" => "required|min:3",
            "eventSlug" => "required|min:3|alpha_dash",
            "eventDate" => "required|after_or_equal:today",
        ]);

        $content = [
            "name" => $data["eventName"],
            "slug" => $data["eventSlug"],
            "date" => $data["eventDate"],
            "user_id" => $request->user()->id,
        ];

        $event = Event::create($content);

        return redirect()->back()->with('success', 'Event created successfully!');
    }

    function detail(Request $request, $eventId) {
        $event = Event::find($eventId);
        $tickets = Ticket::where('event_id', $eventId)->get();
        $channels = Channel::where('event_id', $eventId)->with('rooms.conferences')->get();
        $event['conferences'] =  [];
        $event['channels'] = $channels;
        $event['tickets'] =  [];
        $event['rooms'] = [];
        foreach ($channels as $channel){
            $rooms = $channel->rooms;
            unset($channel['rooms']);
            $channel['rooms'] = count($rooms);
            ($channel['rooms'] == 0) ? $channel['conferences'] = 0 : "";
            foreach ($rooms as $room) {
                $conferences = $room->conferences;
                $channel['conferences'] += count($conferences);
                $roomConferences = [];
                foreach ($conferences as $conference){
                    $conference->start = (new DateTime($conference->start))->format('H:i');
                    $conference->end = (new DateTime($conference->end))->format('H:i');                    
                    $conference->type = ucfirst($conference->type);
                    $conference['channel'] = $channel->name;
                    $conference['room'] = $room->name;
                    $roomConferences[] = [
                        "id" => $conference["id"],
                        "name" => $conference["title"],
                        "registrations" => count($conference["registrations"]),
                    ];
                    
                    unset($conference["registrations"]);
                }
                unset($room["conferences"]);
                $room["conferences"] = $roomConferences;
                $event['conferences'] = array_merge($event['conferences'], $conferences->toArray());
            }
           
            $event['rooms'] = array_merge($event['rooms'], $rooms->toArray());
        }

        foreach ($tickets as $ticket) {
            if ($ticket->special_validity) {
                $srtJson = $ticket->special_validity;
                $json =  json_decode($srtJson, true);
                if ($json['type'] != 'amount') {
                    $ticket['dateUnFormatted'] = $json['date'];
                    $rer = new DateTime($json['date']);
                    $json['date'] = $rer->format('F d, Y');
                }
                $ticket->special_validity = $json;
            }
            $ticket["registration"] = count(Registration::where('ticket_id', $ticket->id)->get());
        }

        $event['tickets'] = array_merge($event['tickets'], $tickets->toArray());


        return view("events.detail")->with(compact('event'));
    }

    public function edit(Request $request, $eventId){
        $data = $request->validate([
            "eventName" => "required|min:3",
            "eventSlug" => "required|min:3|alpha_dash",
            "eventDate" => "required|after_or_equal:today",
        ]);

        $content = [
            "name" => $data["eventName"],
            "slug" => $data["eventSlug"],
            "date" => $data["eventDate"],
        ];

        $event = Event::findOrFail($eventId);
        $event->fill($content);
        $event->save();

        return redirect()->back()->with('success', 'Event edited successfully!');
    }

    public function delete($eventId){
        $event = Event::findOrFail($eventId);
        $event->delete();

        return redirect()->route('dashboard')->with('success', 'Event deleted successfully!');
    }
}
