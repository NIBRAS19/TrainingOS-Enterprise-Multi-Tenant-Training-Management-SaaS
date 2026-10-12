<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('trainingos:recalculate-progress')->dailyAt('01:15');
Schedule::command('trainingos:expire-certificates')->dailyAt('02:00');
