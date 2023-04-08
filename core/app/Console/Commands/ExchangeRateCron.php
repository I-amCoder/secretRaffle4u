<?php
   
namespace App\Console\Commands;
   
use Illuminate\Console\Command;
use DB;
   
class ExchangeRateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchangerate:cron';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
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
		$thb_rates = json_decode(file_get_contents('https://v6.exchangerate-api.com/v6/78a6747b51e1b9b498c3728e/latest/THB'));
		$datetime = date('Y-m-d',$thb_rates->time_last_update_unix);
		$rates = json_encode($thb_rates->conversion_rates);
		$insert_array = [
			'date' => $datetime,
			'rates' => $rates,
			'created_at' => date('Y-m-d H:i:s'),
		];
		DB::table('currency_rates')->insert($insert_array);
    }
}