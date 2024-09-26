<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['channel_id', 'name', 'capacity'];
    public $timestamps = false;


    public function conferences(){
        return $this->hasMany(Conference::class);
    }

    public function channel(){
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }
}
