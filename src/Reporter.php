<?php

namespace HexletPsrLinter;

use HexletPsrLinter\LinterLog;

class Reporter
{
    public static function stdout(LinterLog $logger)
    {
        $log = $logger->getLog();
        print_r($log);
    }
}