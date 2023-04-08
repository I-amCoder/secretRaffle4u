<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $guarded = ['id'];

    public function game()
    {
    	return $this->belongsTo(Game::class);
    }

    public function bids(){
    	return $this->hasMany(Bid::class);
    }

    public function choose(){
    	return $this->hasMany(UserChoose::class);
    }
}
