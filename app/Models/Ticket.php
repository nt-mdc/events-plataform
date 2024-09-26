<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public $table = "event_tickets";
    public $fillable = ["event_id", "name", "special_validity"];
    public $timestamps = false;

    public function registrations() {
        return $this->hasMany(Registration::class, "ticket_id");
    }
}
