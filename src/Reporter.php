<?php

namespace PsrLinter;

use PsrLinter\Logger;

class Reporter
{
    public static function stdout(Logger $logger)
    {
        $log = $logger->getLog();
        $output = '';

        foreach ($log as $item) {
            $output .= $item['line'] . '    ' . $item['type']. '     ' . $item['reason'] . "\n";
        }

        return $output;
    }
}
