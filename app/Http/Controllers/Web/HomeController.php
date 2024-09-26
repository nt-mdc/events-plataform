<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function dashboard(Request $request){
        $events = Event::where('user_id', $request->user()->id)->with('tickets.registrations')->orderBy('date', 'asc')->get();
        foreach ($events as $event) {
            $totalRegistrations = 0;
        
            foreach ($event->tickets as $ticket) {
                $totalRegistrations += $ticket->registrations->count();
            }
        
            $event['registrations'] = $totalRegistrations;
            unset($event->tickets);
        }

        return view('dashboard')->with(compact('events'));
    }}
