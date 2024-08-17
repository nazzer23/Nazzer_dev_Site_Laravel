<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command(App\Console\Commands\UpdateGithubProjects::class)->everyFiveMinutes();
