<?php

Artisan::command('log:clear', function (){
    exec('echo "" > ' . storage_path('logs/laravel.log'));
    $this->comment('Logs have been cleared');

})->describe('Clear Laravel log');
