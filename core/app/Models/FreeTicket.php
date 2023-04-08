<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeTicket extends Model
{
    protected $guarded = ['id'];
    protected $table = 'raffle_game_free_tickets';

}
