<?php

namespace PsrLinter;

function report($errors)
{
    return array_reduce($errors, function ($carry, $item) {
        $carry .= implode("\t", $item) . "\n";
        return $carry;
    }, '');
}
