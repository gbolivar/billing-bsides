<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

class LogServiceProvider extends ServiceProvider
{
    /**
    * Configure logging on boot.
    *
    * @return void
    */
    public function boot()
    {
        app('Psr\Log\LoggerInterface')->setHandlers([$this->getRotatingLogHandler()]);    }

    public function getRotatingLogHandler($maxFiles = 7)
    {
        $filePathLog = config('apps.logger_path') . (env('APP_NAME')) . ".log";
        return (new RotatingFileHandler($filePathLog, $maxFiles))->setFormatter(new LineFormatter(null, null, true, true));
    }

    /**
    * Register the log service.
    *
    * @return void
    */
    public function register()
    {
     // Log binding already registered in vendor/laravel/lumen-framework/src/Application.php.
    }
}