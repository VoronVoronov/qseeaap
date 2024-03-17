<?php

namespace App\Services\Base;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class BaseService
{
    protected function log(string $message): void
    {
        $this->setLogFileName();

        Log::channel('services')->info($message);
    }

    protected function errorLog(string $message): void
    {
        $this->setLogFileName();

        Log::channel('services_error')->error($message);
    }

    private function setLogFileName(): void
    {
        $reflection = new \ReflectionClass($this);

        Config::set('logging.channels.services.path', storage_path('logs/services/default/'. $reflection->getShortName() . '.log'));
        Config::set('logging.channels.services_error.path', storage_path('logs/services/errors/'. $reflection->getShortName() . '.log'));
    }
}
