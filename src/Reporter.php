<?php

namespace PsrLinter;

use PsrLinter\Logger;

class Reporter
{
    public static function stdout(Logger $logger)
    {
        $log = $logger->getLog();
        print_r($log);
    }
}