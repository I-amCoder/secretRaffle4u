<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winning extends Model
{
    protected $guarded = ['id'];
    protected $table = 'winnings';


    public function raffle_game() {
        return $this->hasOne('App\Models\RaffleGame', 'id', 'raffle_game_id');
    }
    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }




}
