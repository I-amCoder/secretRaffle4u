<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'ver_code_send_at' => 'datetime'
    ];

    protected $data = [
        'data'=>1
    ];




    public function login_logs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id','desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status','!=',0);
    }
    public function raffle_tickets()
    {
        return $this->belongsTo('App\Models\RaffleTicket', 'id', 'user_id')->groupBy('raffle_game_id');
        
    }
    public function scratch_cards()
    {
        return $this->belongsTo('App\Models\ScratchGameTicket', 'id', 'purchase_user_id')->whereNotIn('scratch_game_id', [3,4])->groupBy('scratch_game_id');
        
    }
    public function scratch_card_wins()
    {
        return $this->belongsTo('App\Models\ScratchGameTicket', 'id', 'purchase_user_id')->where('winning_price', '>', 0);
        
    }
    public function rafflewins()
    {
        return $this->belongsTo('App\Models\RaffleTicket', 'id', 'user_id')->where('winning_position', '>', 0);
        
    }
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status','!=',0);
    }

    public function referral()
    {
        return $this->hasMany(User::class,'ref_by');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function wins()
    {
        return $this->hasMany(Winner::class);
    }

    public function commissions()
    {
        return $this->hasMany(CommissionLog::class);
    }
    


    // SCOPES

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeActive()
    {
        return $this->where('status', 1);
    }

    public function scopeBanned()
    {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified()
    {
        return $this->where('ev', 0);
    }

    public function scopeSmsUnverified()
    {
        return $this->where('sv', 0);
    }
    public function scopeEmailVerified()
    {
        return $this->where('ev', 1);
    }

    public function scopeSmsVerified()
    {
        return $this->where('sv', 1);
    }

}
