<?php

namespace PsrLinter;

use function PsrLinter\getCheckers;

function makeValidator()
{
    $checkers = getCheckers();

    return function (\PhpParser\Node $node) use ($checkers) {
        return array_reduce($checkers, function ($errors, $check) use ($node) {
            $checkerErrors = $check($node);
            if ($checkerErrors) {
                $errors[] = $checkerErrors;
            }
            return $errors;
        }, []);
    };
}
