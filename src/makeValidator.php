<?php

namespace PsrLinter;

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
