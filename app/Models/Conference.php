<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
    public $table = "conferences";
    protected $fillable = ['room_id', 'title', 'description', 'speaker', 'date', 'start', 'end', 'type'];

    
    public function registrations(){
        return $this->hasMany(Registration::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
