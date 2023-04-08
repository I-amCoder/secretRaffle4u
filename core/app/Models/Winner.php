<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $guarded = ['id'];

    public function phase()
    {
    	return $this->belongsTo(Phase::class)->with('game');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
