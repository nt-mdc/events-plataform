<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;


    public function tickets(){
        return $this->belongsTo(Ticket::class, "ticket_id");
    }

    public function conferences(){
        return $this->belongsTo(Conference::class);
    }

    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
}
