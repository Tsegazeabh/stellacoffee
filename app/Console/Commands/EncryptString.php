<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class EncryptString extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encrypt:text {plain_text}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns a cypher value of provided string value. It uses an application key for the encryption.';

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
        $plain_text = $this->argument('plain_text');
        if (strlen($plain_text) > 0) {
            $this->info(Crypt::encryptString($plain_text));
        } else {
            $this->info('{plain_text} argument is required. You should provide text to be encrypted.');
        }
    }
}
