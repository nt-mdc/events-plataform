<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Event as APIEvent;
use App\Http\Resources\API\EventCollection;
use App\Http\Resources\API\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;


/**
 * @group Event management
 *
 * This API provides functionalities for managing events, including retrieving event details, associated conferences, and available tickets.
 * Its endpoints allow attendees to access event information and related data, ensuring an organized experience for attendees and organizers.
 *
 */

class EventController extends Controller
{


    /**
     * Get a list of events.
     * 
     * This endpoint returns a list of events that have available tickets, along with their basic information.
     * 
     * @authenticated
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "event": {
     *         "id": 1,
     *         "name": "Global Tech Expo 2025",
     *         "date": "2024-11-15"
     *       }
     *     },
     *     {
     *       "event": {
     *         "id": 2,
     *         "name": "World Science Fair 2025",
     *         "date": "2024-12-20"
     *       }
     *     }
     *   ]
     * }
     * 
    * @response 404 {
     *   "message": "No events available."
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */

     
    public function index() {
        $events = Event::has('tickets')->get();
        
        if($events->isEmpty()) {
            return response()->json([
                'message' => 'No events available.'
            ],404);
        }

       return new EventCollection($events);
    }


    /**
     * Get details of a specific event.
     * 
     * This endpoint retrieves detailed information about a specific event, including its tickets and conferences.
     * 
     * @authenticated
     * 
     * @urlParam eventId int required The ID of the event. Example: 1
     * 
     * @response 200 {
     *   "data": {
     *     "event": {
     *       "id": 1,
     *       "name": "Global Tech Expo 2025",
     *       "date": "2024-11-15"
     *     },
     *     "conferences": [
     *       {
     *         "id": 1,
     *         "title": "The Future of AI",
     *         "description": "An in-depth look at the advancements and challenges in AI development.",
     *         "date": {
     *           "start": "2024-12-05 09:00:00",
     *           "end": "2024-12-05 10:30:00"
     *         },
     *         "speaker": "Dr. Sarah Johnson",
     *         "type": "keynote"
     *       }
     *     ],
     *     "tickets": [
     *       {
     *         "id": 1,
     *         "name": "VIP Pass",
     *         "special_validity": null
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 404 {
     *   "message": "Event not found."
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function show($eventId) {
        $event = Event::where('id', $eventId)->has('tickets')->with('tickets', 'channels.rooms.conferences')->first();

        if(!$event) {
            return response()->json([
                'message' => 'Event not found.'
            ],404);
        }

        return new EventResource($event);
    }
}
