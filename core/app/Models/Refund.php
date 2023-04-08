<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $guarded = ['id'];
    protected $table = 'refunds';


    public function raffle_game() {
        return $this->hasOne('App\Models\RaffleGame', 'id', 'raffle_game_id');
    }
    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }




}
