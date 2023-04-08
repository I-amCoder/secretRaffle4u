<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paytable extends Model
{
    protected $guarded = ['id'];
    protected $table = 'paytables';


    public function scratch() {
        return $this->belongsTo('App\Models\ScratchGame', 'scratch_id', 'id');
    }




}