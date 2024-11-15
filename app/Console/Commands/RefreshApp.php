<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-app';

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
        $this->call('migrate:refresh');
        $this->call('passport:install');
        $this->call('config:cache');
    }
}
