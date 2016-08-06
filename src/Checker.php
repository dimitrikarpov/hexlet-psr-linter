<?php

namespace PsrLinter;

class Checker
{
    /**
     * Check functions naming, according to these rule:
     * * Method names MUST be declared in camelCase.
     *
     * @param $name function name
     *
     * @return array|bool true or error description
     */
    public static function functionsNaming($name)
    {
        $reason = 'Method names MUST be declared in camelCase.';

        if (!\PHP_CodeSniffer::isCamelCaps($name)) {
            return ['type' => 'error', 'reason' => "{$reason}", "where" => $name];
        }

        return true;
    }
}
