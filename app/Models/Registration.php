<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function tickets(){
        return $this->belongsTo(Ticket::class, "ticket_id");
    }

    public function conferences(){
        return $this->belongsToMany(Conference::class, "conference_registration", "registration_id", "conference_id");
    }
}
