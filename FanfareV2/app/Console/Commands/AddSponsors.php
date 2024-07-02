<?php

namespace App\Console\Commands;
use App\Services\SponsorsService;
use Illuminate\Console\Command;

class AddSponsors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-sponsors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sponsorService=new SponsorsService();
        $sponsorService->run();
    }
}
