<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['win_bonus'];

    public function phases(){
    	return $this->hasMany(Phase::class);
    }
}
