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

    if (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $name)) {
        return ['type' => 'error', 'reason' => "{$reason}", "where" => $name];
    }

    return true;
}
