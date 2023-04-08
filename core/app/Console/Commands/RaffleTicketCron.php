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
   
class RaffleTicketCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raffleticket:cron';
    
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
        $games = RaffleGame::where('tickets_created',0)->where('draw_status',0)->where('status',1)->orderBy('category_id','ASC')->limit(1)->get();
		// echo "<pre>";print_r($games);echo "</pre>";exit;
        foreach ($games as $key => $value) {
            $created_tickets = DB::table('raffle_game_tickets')->where('raffle_game_id', $value->id)->count();
            $total_tickets = $value->total_tickets;
			if($created_tickets >= $value->total_tickets){
				DB::table('raffle_games')->where('id', $value->id)->update(['tickets_created' => 1]);	
				break;
			}
			$ten_percent = ((10/100)*$value->total_tickets);
			if($ten_percent >= $created_tickets){
				DB::table('raffle_games')->where('id', $value->id)->update(['show' => 1]);	
			}
			$length = ceil(log10($value->total_tickets));
            if($total_tickets > $created_tickets){
				for($i=0;$i<1000;$i++){
					$data = [];
					for($x=0;$x<1000;$x++){
						$created_tickets++;
						// echo $length;exit;
						$t_code = str_pad($created_tickets, $length, '0', STR_PAD_LEFT);
						// echo $t_code;exit;
						$data[] = [
							'code'              => $t_code,
							'ticket_no'         => $created_tickets,
							'status'            => 1,
							'raffle_game_id'    => $value->id,
							'unit_price'        => $value->unit_price,
							'is_booked'         => 0,
							'winning_position'  => 0,
							'created_at'        => date('Y-m-d H:i:s'),
							'created_by'        => 1,
						];
						if($created_tickets == $value->total_tickets){
							DB::table('raffle_game_tickets')->insert($data);
							DB::table('raffle_games')->where('id', $value->id)->update(['tickets_created' => 1]);
							break 3;
						}
					}
					DB::table('raffle_game_tickets')->insert($data);
				}
            }
        }
    }
}