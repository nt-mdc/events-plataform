<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create(Request $request) {
        $data = $request->validate([
            'ticketName' => 'required|min:3',
            'ticketDate' => 'nullable|after_or_equal:today',
            'ticketNumber' => 'nullable|integer|min:1',
            'event_id' => 'required'
        ]);
    
        $ticketValidity = [];
        if ($request->has('ticketValidity')) {
            if ($data['ticketNumber']) {
                $ticketValidity = ["type" => "amount", "amount" => $data['ticketNumber']];
            }
    
            if ($data['ticketDate']) {
                $ticketValidity = ["type" => "date", "date" => $data['ticketDate']];
            }
        }

        $content = [
            "event_id" => $data['event_id'],
            "name" => $data['ticketName'],
            "special_validity" => $ticketValidity  ? json_encode($ticketValidity ) : null,

        ];
    
        $ticket = new Ticket();
        $ticket->fill($content);
        $ticket->save();
    
        return redirect()->back()->with('success', 'Ticket created successfully!');
    }

    public function edit(Request $request, $ticketId) {
        $data = $request->validate([
            'ticketName' => 'nullable|min:3',
            'ticketDate' => 'nullable|after_or_equal:today',
            'ticketNumber' => 'nullable|integer|min:1',
        ]);
    
        $ticketValidity = [];
        if ($request->has('ticketValidity')) {
            if ($data['ticketNumber']) {
                $ticketValidity = ["type" => "amount", "amount" => $data['ticketNumber']];
            }
    
            if ($data['ticketDate']) {
                $ticketValidity = ["type" => "date", "date" => $data['ticketDate']];
            }
        }

        $content = [
            "name" => $data['ticketName'],
            "special_validity" => $ticketValidity  ? json_encode($ticketValidity ) : null,

        ];
    
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->fill($content);
        $ticket->save();
    
        return redirect()->back()->with('success', 'Ticket edited successfully!');
    }

    public function delete($ticketId) {
        
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->delete();
    
        return redirect()->back()->with('success', 'Ticket deleted successfully!');
    }

    
    
    

}