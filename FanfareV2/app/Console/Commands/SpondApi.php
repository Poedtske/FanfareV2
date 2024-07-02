<?php

namespace App\Console\Commands;

use App\Services\SpondService;
use Illuminate\Console\Command;

class SpondApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:spond-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch events from Spond API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $spondService=new SpondService("Spond_api.py");
        $spondService->run();
    }
}
