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

/**
 * Check variable name, according to these rules:
 * * Property names SHOULD NOT be prefixed with a single underscore to indicate protected or private visibility.
 * @param $name variable name
 *
 * @return array|bool true or error description
 */
function checkVariableNaming($name)
{
    $reason = "Property names SHOULD NOT be prefixed with a single" .
              " underscore to indicate protected or private visibility.";

    if (preg_match('/^_.+/', $name)) {
        return ['type' => 'error', 'reason' => "{$reason}", "where" => $name];
    }

    return true;
}
