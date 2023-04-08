<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChoose extends Model
{
    protected $guarded = ['id'];

    public function phase()
    {
    	return $this->belongsTo(Phase::class,'phase_id');
    }

    public function bid()
    {
    	return $this->belongsTo(bid::class,);
    }
}
