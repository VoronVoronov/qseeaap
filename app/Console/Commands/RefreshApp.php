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
        $this->call('cache:clear');
        $this->call('migrate:refresh');
        $this->call('passport:install');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        $this->call('db:seed');
    }
}
