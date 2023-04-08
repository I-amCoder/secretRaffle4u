<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;
use App\Models\RaffleTicket;
use App\Models\RaffleGameSetting;


class RaffleGame extends Model
{
    protected $guarded = ['id'];
    protected $table = 'raffle_games';

    public function category()
    {
        return $this->hasOne('App\Models\RaffleCategory', 'id', 'category_id');
    }
    public function draw_status()
    {
        $total_tickets = RaffleTicket::where('raffle_game_id', $this->id)->count();
        if ($total_tickets >= $this->min_tickets) {
            return true;
        } else {
            return false;
        }
    }

    public function winning_positions()
    {
        return $this->hasMany(RaffleGameSetting::class, 'raffle_game_id', 'id')->where('winning_position', '!=', null);
    }
    public function blocked_positions()
    {
        return $this->hasMany(RaffleGameSetting::class, 'raffle_game_id', 'id')->where('blocked_position', '!=', null);
    }

    public function my_tickets_count()
    {
        $count = RaffleTicket::where('raffle_game_id', $this->id)->where('user_id', auth()->user()->id)->count();
        $amount = RaffleTicket::where('raffle_game_id', $this->id)->where('user_id', auth()->user()->id)->sum('amount');
        $res['ticket_count'] = $count;
        $res['amount'] = $amount;
        return $res;
    }
    public function my_tickets()
    {
        $tickets = RaffleTicket::where('raffle_game_id', $this->id)->where('user_id', auth()->user()->id)->orderBy('winning_position', 'ASC')->get();
        // $res['amount'] = $tickets;
        return $tickets;
    }

    public function tickets_sold()
    {
        $total_tickets_sold = RaffleTicket::where('raffle_game_id', $this->id)->count();
        return $total_tickets_sold;
    }
}
