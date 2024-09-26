<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "roomName" => "required|min:3",
            "roomChannel" => "required",
            "roomCapacity" => "required|integer|min:1",
        ]);

        $content = [
            "name" => $data["roomName"],
            "channel_id" => $data["roomChannel"],
            "capacity" => $data["roomCapacity"],
        ];

        $room = Room::create($content);

        return redirect()->back()->with('success', 'Room created successfully!');
    }

    public function edit(Request $request, $roomId){
        $data = $request->validate([
            "roomName" => "required|min:3",
            "roomChannel" => "required",
            "roomCapacity" => "required|integer|min:1",
        ]);

        $content = [
            "name" => $data["roomName"],
            "channel_id" => $data["roomChannel"],
            "capacity" => $data["roomCapacity"],
        ];

        $room = Room::findOrFail($roomId);
        $room->fill($content);
        $room->save();

        return redirect()->back()->with('success', 'Room edited successfully!');
    }

    public function delete($roomId){
        $room = Room::findOrFail($roomId);
        $room->delete();

        return redirect()->back()->with('success', 'Room deleted successfully!');
    }
}
