<?php

namespace App;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Laravel\Lumen\Application as LumenApplication;

class Application extends LumenApplication
{
    /**
     * {@inheritdoc}
     */
    protected function getMonologHandler()
    {
        $maxRotatedFiles = 3;
        $d  =   date('Y-m-d');
        $filePathLog = config('apps.logger_path') . (env('APP_NAME')) . "-error-{$d}.log";
        return (new RotatingFileHandler($filePathLog, $maxRotatedFiles))
        ->setFormatter(new LineFormatter(null, null, true, true));
    }
}