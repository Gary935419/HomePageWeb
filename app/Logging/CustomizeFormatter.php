<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $dateFormat = 'Y-m-d H:i:s';					// The format of the timestamp
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter('%level_name% - %datetime%  -->'." %message% %context% %extra%\n", $dateFormat, true, true));
        }
    }
}
