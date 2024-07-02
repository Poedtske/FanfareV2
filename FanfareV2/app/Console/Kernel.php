<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SpondApi::class
      ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('db:database-seeder')->once()->when(function () {
        //     // Condition to check if the seeder should be executed
        //     // You can check if the database is empty or any other condition
        //     return DB::table('scanlator_table')->exists(); // Example condition
        // });
        $schedule->command('app:spond-api')->weeklyOn(1, '8:00');;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
