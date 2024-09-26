<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
    public $table = "conferences";
    protected $fillable = ['room_id', 'title', 'description', 'speaker', 'start', 'end', 'type'];
    public $timestamps = false;

    public function registrations(){
        return $this->belongsToMany(Registration::class, "conference_registration", "conference_id", "registration_id");
    }
}
