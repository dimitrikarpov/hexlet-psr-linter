<?php

namespace PsrLinter;

/**
 * Check functions naming, according to these rule: Method names MUST be declared in camelCase.
 *
 * @param $name function name
 *
 * @return array|bool true or error description
 */
function checkFunctionsNaming($name)
{
    $reason = 'Method names MUST be declared in camelCase.';

    if (!\PHP_CodeSniffer::isCamelCaps($name)) {
        return ['type' => 'error', 'reason' => "{$reason}", "where" => $name];
    }

    return true;
}
