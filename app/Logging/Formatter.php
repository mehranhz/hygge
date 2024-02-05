<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;

class Formatter
{
    /**
     * @param $logger
     * @return void
     */
    public function __invoke($logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\']));
        }
    }
}
