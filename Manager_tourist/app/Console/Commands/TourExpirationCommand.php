<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Tour;

class TourExpirationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tour-expiration-command';

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
        // $now = Carbon::now();
        // $this->info("something");
        // Tour::where('departure_day', '<', $now)
        //     ->update(['t_status' => 0]);
        // Tour::where('departure_day', '>', $now)
        //     ->where('return_day', '<', $now)
        //     ->update(['t_status' => 1]);
        // Tour::where('return_day', '<', $now)
        //     ->update(['t_status' => 2]);


    }
}
