<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Event as APIEvent;
use App\Http\Resources\API\EventCollection;
use App\Http\Resources\API\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
       $events = Event::has('tickets')->with('tickets', 'channels.rooms.conferences')->get();

       return new EventCollection($events);
    }

    public function show($eventId) {
        $event = Event::where('id', $eventId)->has('tickets')->with('tickets', 'channels.rooms.conferences')->first();

        return new EventResource($event);
    }
}
