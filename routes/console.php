<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-sync products from external API every 15 minutes as long as API URL is configured
Schedule::command('products:sync')->everyFifteenMinutes()->withoutOverlapping();

