<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class SimpleFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            // Define the log format, ensuring it ends with a newline character
            $output = "[%datetime%]:\n%message% \n%context%\n";
            $formatter = new LineFormatter($output, null, true, true);
            $handler->setFormatter($formatter);
        }
    }
}
