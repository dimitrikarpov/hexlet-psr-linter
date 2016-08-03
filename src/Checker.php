<?php

namespace HexletPsrLinter;

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
        $result = preg_match("/[a-z]+(_)[a-z0-9]+/i", $name);
        $reason = 'Method names MUST be declared in camelCase.';

        if ($result == 1) {
            return ['type' => 'error', 'reason' => "{$name}: {$reason}"];
        }

        return true;
    }
}
