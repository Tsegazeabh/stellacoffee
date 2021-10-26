<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DisplayLoginUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'display:login-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays the current url used to login to the content management system.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(route('login'));
        return 0;
    }
}
