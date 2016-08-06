<?php

namespace PsrLinter;

class Reporter
{
    public static function stdout($errors)
    {
        $output = '';

        foreach ($errors as $item) {
            $output .= "{$item['line']}\t{$item['type']}\t{$item['where']}\t{$item['reason']}\n";
        }

        return $output;
    }
}
