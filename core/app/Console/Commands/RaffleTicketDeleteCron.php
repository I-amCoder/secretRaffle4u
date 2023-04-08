<?php
   
namespace App\Console\Commands;
   
use Illuminate\Console\Command;

use App\Models\RaffleGame;
use App\Models\RaffleTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;
use App\Lib\Helper;
   
class RaffleTicketDeleteCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raffleticketdelete:cron';
    
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
		$raffle_game = RaffleGame::where('draw_status',1)->where('status',1)->where('tickets_deleted',0)->first();
		// echo "<pre>";print_r($raffle_game);echo "</pre>";exit;
/**/
		if(!empty($raffle_game)){
			// echo "<pre>";print_r($raffle_game);echo "</pre>";exit;
			$deleted = DB::table('raffle_tickets')->where('raffle_game_id',$raffle_game->id)->whereRaw('(winning_position = 0 || winning_position IS NULL)')->limit(100000)->delete();
			// echo "<pre>";print_r($deleted);echo "</pre>";exit;
			// echo "here";exit;
			$ifBoughtTicketsExists = DB::table('raffle_tickets')->where('raffle_game_id',$raffle_game->id)->whereRaw('(winning_position = 0 || winning_position IS NULL)')->first();
			if(empty($ifBoughtTicketsExists)){
				// echo "here";exit;
				DB::table('raffle_game_tickets')->where('raffle_game_id',$raffle_game->id)->limit(500000)->delete();
				$ifTicketsExists = DB::table('raffle_game_tickets')->where('raffle_game_id',$raffle_game->id)->first();
				if(empty($ifTicketsExists)){
					// echo "here";exit;
					RaffleGame::where('id',$raffle_game->id)->update(['tickets_deleted'=>1]);
				}
			}else{
				// echo "there";exit;
			}
		}
/**/
    }
}