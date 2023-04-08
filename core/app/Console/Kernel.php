<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
		Commands\DemoCron::class,
		Commands\RaffleCron::class,
		Commands\RaffleTicketCron::class,
		Commands\RaffleTicketDeleteCron::class,
		Commands\ExchangeRateCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		$schedule->command('demo:cron')->everyMinute();
		$schedule->command('raffle:cron')->everyMinute();
		$schedule->command('raffleticket:cron')->everyMinute();
		$schedule->command('raffleticketdelete:cron')->everyMinute();
		$schedule->command('exchangerate:cron')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
