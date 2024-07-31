<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;
use App\Models\Tour;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('app:tour-expiration-command', function () {
    $now = Carbon::now();

    Tour::where('departure_day', '>', $now)
        ->update(['t_status' => 0]);

    Tour::where('departure_day', '<=', $now)
        ->where('return_day', '>=', $now)
        ->update(['t_status' => 1]);

    Tour::where('return_day', '<', $now)
        ->update(['t_status' => 2]);
})->purpose('Display an inspiring quote')->everySecond();
