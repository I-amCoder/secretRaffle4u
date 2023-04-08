<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class ScratchGame extends Model

{

    protected $guarded = ['id'];

    protected $table = 'scratch_games';





    public function category() {

        return $this->hasOne('App\Models\ScratchCategory', 'id', 'category_id');

    }
    public function paytable() {

        return $this->hasMany('App\Models\Paytable', 'scratch_id', 'id')->orderBy('id','ASC');

    }
    public function my_scratch_count()
    {
        $count = ScratchGameTicket::where('scratch_game_id', $this->id)->where('purchase_user_id', auth()->user()->id)->count();
        $amount = ScratchGameTicket::where('scratch_game_id', $this->id)->where('purchase_user_id', auth()->user()->id)->sum('unit_price');
        $res['scratch_count'] = $count;
        $res['amount'] = $amount;
        return $res;
    }
    public function tickets_sold()
    {
        $count = ScratchGameTicket::where('scratch_game_id', $this->id)->count();
        return $count;
    }









}