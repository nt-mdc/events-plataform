<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class RegistrationController extends Controller
{
    public function registerAttendee(Request $request)
    {
        $attendee = $request->user();

        $request->validate([
            'ticket_id' => 'required|exists:event_tickets,id',
            'conference_id' => 'required|exists:conferences,id',
        ]);

        $existingRegistration = Registration::where([
            ['ticket_id', '=', $request->ticket_id],
            ['conference_id', '=', $request->conference_id],
            ['attendee_id', '=', $attendee->id]
        ])->first();
        
        if ($existingRegistration) {
            return response()->json([
                'message' => 'The attendee is already registered for this conference.'
            ], 409);
        }


        $ticket = Ticket::find($request->ticket_id);

        $ticket->registrations = $ticket->registrations->count();
        
        if ($ticket->special_validity) {
            $ticketValidity = json_decode($ticket->special_validity);

            if ($ticketValidity->type == 'date') {
                $now = date('Y-m-d');
                $ticketDate = $ticketValidity->date;
                
                if ($now > $ticketDate) {
                    return response()->json([
                        'message' => 'The ticket is no more available.'
                    ], 422);
                }
            }

            if ($ticketValidity->type == 'amount') {
                $total = $ticket->registrations;
                $limit = $ticketValidity->amount;

                if ($total >= $limit) {
                    return response()->json([
                        'message' => 'The ticket is no more available.'
                    ], 422);
                }
            }
        }

        $conference = Conference::find($request->conference_id);
        
        $room = $conference->room;
        $channel = $room->channel;
        $event = $channel->event;

        if ($event->id != $ticket->event_id) {
            return response()->json([
                'message' => 'The selected ticket does not belong to the event associated with this conference.'
            ], 422);
        }

        $newRegistration = new Registration();
        $newRegistration->attendee_id = $attendee->id;
        $newRegistration->ticket_id = $ticket->id;
        $newRegistration->conference_id = $conference->id;
        $newRegistration->save();
        

        return response()->json([
            'message' => 'Attendee successfully registered to the conference.',
            'registration' => $newRegistration
        ],201);
    }

    public function removeRegistration(Request $request)
    {

        $attendee = $request->user();

        $request->validate([
            'ticket_id' => 'required|exists:event_tickets,id',
            'conference_id' => 'required|exists:conferences,id',
        ]);


        $registration = Registration::where([
            ['ticket_id', '=', $request->ticket_id],
            ['conference_id', '=', $request->conference_id],
            ['attendee_id', '=', $attendee->id]
        ])->first();

        if (!$registration) {
            return response()->json([
                'message' => 'Registration not found for this attendee in the specified conference.'
            ], 404);
        }
        
        $registration->delete();

        return response()->json([
            'message' => 'Registration successfully removed.'
        ], 200);
    }
}
