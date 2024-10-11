<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'event' => [
                'id' => $this->id,
                'name' => $this->name,
                'date' => $this->date,
            ],
            'conferences' => $this->channels->flatMap(function($channel) {
                return $channel->rooms->flatMap(function($room) {
                    return $room->conferences->map(function($conference) {
                        return [
                            'id' => $conference->id,
                            'title' => $conference->title,
                            'description' => $conference->description,
                            'date' => [
                                'start' => $conference->start,
                                'end' => $conference->end,
                            ],
                            'speaker' => $conference->speaker,
                            'type' => $conference->type,
                        ];
                    });
                });
            }),
            'tickets' => $this->tickets->map(function($ticket) {
                return [
                    'id' => $ticket->id,
                    'name' => $ticket->name,
                    'special_validity' =>json_decode($ticket->special_validity),
                ];
            }),
        ];
    }
}
