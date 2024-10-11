<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = [
        "event_id",
        "name"
    ];

    
    public function rooms() {
        return $this->hasMany(Room::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }


}
