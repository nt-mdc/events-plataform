<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "eventDate" => "required",
            "conferenceTitle" => "required|min:3|max:255",
            "conferenceDescription" => "required|min:25|max:1500",
            "conferenceType" => "required",
            "conferenceSpeaker" => "required|min:3",
            "conferenceRoom" => "required",
            "conferenceStart" => "required|date_format:H:i",
            "conferenceEnd" => "required|date_format:H:i|after:conferenceStart",
            "conferenceDate" => "required|after_or_equal:eventDate",
        ]);

        $content = [
            "title" => $data["conferenceTitle"],
            "description" => $data["conferenceDescription"],
            "type" => $data["conferenceType"],
            "speaker" => $data["conferenceSpeaker"],
            "room_id" => $data["conferenceRoom"],
            "date" => $data["conferenceDate"],
            "start" => $data["conferenceStart"],
            "end" => $data["conferenceEnd"],
        ];

        $conference = Conference::create($content);

        return redirect()->back()->with('success', 'Conference created successfully!');
    }

    public function edit(Request $request, $conferenceId){
        $data = $request->validate([
            "eventDate" => "required",
            "conferenceTitle" => "required|min:3|max:255",
            "conferenceDescription" => "required|min:25|max:1500",
            "conferenceType" => "required",
            "conferenceSpeaker" => "required|min:3",
            "conferenceRoom" => "required",
            "conferenceStart" => "required|date_format:H:i",
            "conferenceEnd" => "required|date_format:H:i|after:conferenceStart",
            "conferenceDate" => "required|after_or_equal:eventDate",
        ]);

        $content = [
            "title" => $data["conferenceTitle"],
            "description" => $data["conferenceDescription"],
            "type" => $data["conferenceType"],
            "speaker" => $data["conferenceSpeaker"],
            "room_id" => $data["conferenceRoom"],
            "date" => $data["conferenceDate"],
            "start" => $data["conferenceStart"],
            "end" => $data["conferenceEnd"],
        ];


        $conference = Conference::findOrFail($conferenceId);
        $conference->fill($content);
        $conference->save();

        return redirect()->back()->with('success', 'Conference edited successfully!');
    }

    public function delete($conferenceId){
        $conference = Conference::findOrFail($conferenceId);
        $conference->delete();
    
        return redirect()->back()->with('success', 'Conference deleted successfully!');
    }
}
