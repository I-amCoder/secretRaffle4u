<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaffleGameSetting extends Model
{
    protected $guarded = ['id'];
    protected $table = 'raffle_winner_settings';


    public function raffle_game() {
        return $this->hasOne('App\Models\RaffleGame', 'id', 'raffle_game_id');
    }




}
