<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "channelName" => "required|min:3",
            "event_id" => "required"
        ]);

        $content = [
            "name" => $data["channelName"],
            "event_id" => $data["event_id"]
        ];

        $channel = Channel::create($content);

        return redirect()->back()->with('success', 'Channel created successfully!');
    }

    public function edit(Request $request, $channelId){
        $data = $request->validate([
            "channelName" => "required|min:3",
            "event_id" => "required"
        ]);

        $content = [
            "name" => $data["channelName"],
            "event_id" => $data["event_id"]
        ];

        $channel = Channel::findOrFail($channelId);
        $channel->fill($content);
        $channel->save();

        return redirect()->back()->with('success', 'Channel edited successfully!');
    }

    public function delete($channelId){
        $channel = Channel::findOrFail($channelId);
        $channel->delete();

        return redirect()->back()->with('success', 'Channel deleted successfully!');
    }

}
