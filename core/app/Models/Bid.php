<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['user_choose'];

    public function game(){
    	return $this->belongsTo(Game::class);
    }

    public function phase(){
    	return $this->belongsTo(Phase::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function chooses(){
        return $this->hasMany(UserChoose::class);
    }
}
