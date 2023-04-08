<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ScratchGameTicket extends Model
{
    protected $guarded = ['id'];
    protected $table = 'scratch_game_tickets';

    public function scratch_game() {
        return $this->hasOne('App\Models\ScratchGame', 'id', 'scratch_game_id');
    }
	
    public function scratch_game_category() {
        return $this->hasOne('App\Models\ScratchCategory', 'id', 'scratch_category_id');
    }









}