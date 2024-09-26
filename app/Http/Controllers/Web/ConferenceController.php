<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "conferenceTitle" => "required|min:3",
            "conferenceDescription" => "required|min:25",
            "conferenceType" => "required",
            "conferenceSpeaker" => "required|min:3",
            "conferenceRoom" => "required",
            "conferenceStartDate" => "required|after_or_equal:today",
            "conferenceEndDate" => "required|after:conferenceStartDate",
        ]);

        $content = [
            "title" => $data["conferenceTitle"],
            "description" => $data["conferenceDescription"],
            "type" => $data["conferenceType"],
            "speaker" => $data["conferenceSpeaker"],
            "room_id" => $data["conferenceRoom"],
            "start" => $data["conferenceStartDate"],
            "end" => $data["conferenceEndDate"],
        ];

        $conference = Conference::create($content);

        return redirect()->back()->with('success', 'Conference created successfully!');
    }

    public function edit(Request $request, $conferenceId){
        $data = $request->validate([
            "conferenceTitle" => "required|min:3",
            "conferenceDescription" => "required|min:25",
            "conferenceType" => "required",
            "conferenceSpeaker" => "required|min:3",
            "conferenceRoom" => "required",
            "conferenceStartDate" => "required|after_or_equal:today",
            "conferenceEndDate" => "required|after:conferenceStartDate",
        ]);

        $content = [
            "title" => $data["conferenceTitle"],
            "description" => $data["conferenceDescription"],
            "type" => $data["conferenceType"],
            "speaker" => $data["conferenceSpeaker"],
            "room_id" => $data["conferenceRoom"],
            "start" => $data["conferenceStartDate"],
            "end" => $data["conferenceEndDate"],
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
