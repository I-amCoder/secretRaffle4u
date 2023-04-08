<?php
   
namespace App\Console\Commands;
   
use Illuminate\Console\Command;

use App\Models\RaffleGame;
use App\Models\RaffleTicket;
use App\Models\User;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;
use App\Lib\Helper;
   
class RaffleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raffle:cron';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Raffle Command description';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		// exit;
        // $time = Carbon\Carbon::now()->addHours(4);
        $time = Carbon\Carbon::now();
        $end_time=$time->toDateTimeString();
        $games = RaffleGame::where('end_time', '<', $end_time)->where('status', 1)->where('draw_status', 0)->get();
        // $games = RaffleGame::where('id', 3)->get();
        
        foreach ($games as $key => $game) {
            if($game->draw_status()){
            // if (1) {

                // min tickets completed
                $assigned_positions = array();
                $assigned_user = array();
                // dd($game->winning_positions);
                foreach ($game->winning_positions as $key => $winner) {
                    // echo "ass"; exit;
                    // dd($winner);
                    $winning_ticket = RaffleTicket::where('user_id', $winner->user->id)
                    ->where('raffle_game_id', $game->id)
                    ->where('winning_position', null)
                    ->inRandomOrder()->first();
                    if ($winning_ticket) {
                        $winning_ticket->winning_position = $winner->winning_position;
                        $winning_ticket->save();
                        $assigned_positions[]=$winner->winning_position;
                        $assigned_user[$winner->winning_position]=$winner->user->id;
                    }
                    

                }
                // dd($assigned_user);
                foreach ($game->blocked_positions as $key => $blocked) {
                    if ($blocked->blocked_position == 0) {
                        RaffleTicket::where('user_id', $blocked->user->id)
                        ->where('raffle_game_id', $game->id)
                        ->where('blocked_position', 0)
                        ->update(['blocked_position'=> -1]);
                    }else{
                        RaffleTicket::where('user_id', $blocked->user->id)
                        ->where('raffle_game_id', $game->id)
                        ->where('blocked_position', 0)
                        ->update(['blocked_position'=>$blocked->blocked_position]);
                    }
                }
                // dd($games);
                $raffle_game_winning_segments = DB::table('raffle_game_winning_segments')->where('raffle_game_id', $game->id)
                ->where('status', 0)->get();
                if (count($raffle_game_winning_segments) > 0) {
                    # code...
                
                    foreach ($raffle_game_winning_segments as $key => $segment) {
                        
                        if ($segment->type == 1) {

                            if (in_array($segment->position,$assigned_positions)) {
                                RaffleTicket::where('winning_position', $segment->position)
                                ->where('raffle_game_id', $game->id)
                                ->update(['winning_price' => $segment->gift_price]);
                                $winner_id = $assigned_user[$segment->position];
                                $win_user = User::find($winner_id);
                                $gift_price_usd = $segment->gift_price;
                                $hlp = new Helper;
                                $gift_price_usd = $hlp->convert_to_currency('USD', $gift_price_usd);
                                $winnings = $gift_price_usd + $win_user->winnings;
                                $win_user->winnings = $winnings;
                                $win_user->save();
                                
                                
                            }else{
                                
                                $winner_segment =  RaffleTicket::whereRaw('NOT FIND_IN_SET(-1,blocked_position) and NOT FIND_IN_SET('.$segment->position.',blocked_position)')
                                ->where('raffle_game_id', $game->id)
                                ->whereNull('winning_position')
                                ->inRandomOrder()->first();
                                // $winner_segment =  RaffleTicket::whereNotIn('blocked_position',[$segment->position,-1])
                                // ->where('raffle_game_id', $game->id)
                                // ->whereNull('winning_position')
                                // ->inRandomOrder()->first();
                                // echo "<pre>";print_r($winner_segment);echo "</pre>";exit;
                                if ($winner_segment) {
                                    RaffleTicket::where('id', $winner_segment->id)
                                    ->update(['winning_position' => $segment->position, 'winning_price' => $segment->gift_price]);
                                    $win_user = User::find($winner_segment->user_id);
                                    $gift_price_usd = $segment->gift_price;
                                    $hlp = new Helper;
                                    $gift_price_usd = $hlp->convert_to_currency('USD', $gift_price_usd);
                                    $winnings = $gift_price_usd + $win_user->winnings;
                                    $win_user->winnings = $winnings;
                                    $win_user->save();
                                    
                                }
                                
                                
                            }
                            DB::table('raffle_game_winning_segments')->where('id', $segment->id)
                                ->update(['status' => 1]);
                        }elseif ($segment->type == 2) {
                            if ($segment->loop_start <= 0) {
                                $diff =$segment->position_end - $segment->position;
                                $loop_start = $segment->position;
                            }else{
                                $diff = $segment->position_end - $segment->loop_start;
                                $loop_start = $segment->loop_start;
                            }
                            
                            if ($diff <= 500) {
                                $loop_end = $segment->position_end;
                                $status = 1;
                            }else{
                                $loop_end = $loop_start + 500;
                                $status = 0;
                            }
                            for ($i=$loop_start; $i <= $loop_end ; $i++) {
                                if (in_array($i,$assigned_positions)) {
                                    RaffleTicket::where('winning_position', $i)
                                    ->where('raffle_game_id', $game->id)
                                    ->update(['winning_price' => $segment->gift_price]);
                                    
                                }else{
                                    $winner_segment =  RaffleTicket::whereRaw('NOT FIND_IN_SET(-1,blocked_position) and NOT FIND_IN_SET('.$i.',blocked_position)')
                                    ->where('raffle_game_id', $game->id)
                                    ->whereNull('winning_position')
                                    ->inRandomOrder()->first();
                                    // $winner_segment =  RaffleTicket::whereNotIn('blocked_position',[$i,-1])
                                    // ->where('raffle_game_id', $game->id)
                                    // ->whereNull('winning_position')
                                    // ->inRandomOrder()->first();
                                    $upd = array();
                                    if ($winner_segment) {
                                        $upd['winning_position'] = $i;
                                        $upd['winning_price'] = $segment->gift_price;
                                        RaffleTicket::where('id', $winner_segment->id)
                                        ->update($upd);
                                        $win_user = User::find($winner_segment->user_id);
                                        $gift_price_usd = $segment->gift_price;
                                        $hlp = new Helper;
                                        $gift_price_usd = $hlp->convert_to_currency('USD', $gift_price_usd);
                                        $winnings = $gift_price_usd + $win_user->winnings;
                                        $win_user->winnings = $winnings;
                                        $win_user->save();
                                    }
                                }
                                
                            }
                            DB::table('raffle_game_winning_segments')->where('id', $segment->id)
                                ->update(['status' => $status , 'loop_start' => $loop_end]);

                        }


                        

                    }
                }else{
                    RaffleGame::where('id', $game->id)->update(['draw_status' => 1, 'winner_selected' => 1]);
                }
            }else{
				if($game->category_id > 1 && $game->category_id < 5){
					$startDate = $game->start_time;
					$endDate = $game->end_time;
					if($game->category_id == 2){
						// $date = date('Y-m-d H:i:s');
						$new_start_date = date('Y-m-d H:i:s',strtotime($startDate . ' +1 day'));
						$new_end_date = date('Y-m-d H:i:s',strtotime($startDate . ' +1 day'));
					}elseif($game->category_id == 3){
						// $date = date('Y-m-d H:i:s');
						$new_start_date = date('Y-m-d H:i:s',strtotime($startDate . ' +7 day'));
						$new_end_date = date('Y-m-d H:i:s',strtotime($startDate . ' +7 day'));
					}elseif($game->category_id == 4){
						// $date = date('Y-m-d H:i:s');
						$new_start_date = date('Y-m-d H:i:s',strtotime($startDate . ' +30 day'));
						$new_end_date = date('Y-m-d H:i:s',strtotime($startDate . ' +30 day'));
					}
					RaffleGame::where('id', $game->id)->update(['start_time' => $new_start_date, 'end_time' => $new_end_date]);
				}
				/*
                $total_buyers = RaffleTicket::where('raffle_game_id', $game->id)->groupBy('user_id')->get();
                
                foreach ($total_buyers as $key => $refund_user) {
                    $total_amount = RaffleTicket::where('user_id', $refund_user->user_id)
                    ->where('raffle_game_id', $game->id)->sum('amount');
                    RaffleTicket::where('user_id', $refund_user->user_id)
                    ->where('raffle_game_id', $game->id)->update(['refunded' => 1]);
                    
                    $refund = new Refund;
                    $refund->user_id = $refund_user->id;
                    $refund->raffle_game_id = $game->id;
                    $refund->amount = $total_amount;
                    $refund->save();

                    $refund_usd = $total_amount;
                    $hlp = new Helper;
                    $refund_usd = $hlp->convert_to_currency('USD', $refund_usd);
                    $user = User::find($refund_user->user_id);
                    $balance = $refund_usd + $user->balance;
                    $user->balance = $balance;
                    $user->save();
                }
                RaffleGame::where('id', $game->id)->update(['draw_status' => 1, 'winner_selected' => 2]);
				*/
            }
        }
        // dd($games);
    }
}