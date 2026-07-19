<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('app:name', function () {
    $this->info(config('app.name'));
});
