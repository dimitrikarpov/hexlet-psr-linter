<?php

namespace PsrLinter;

function reporter($errors)
{
    return array_reduce($errors, function ($carry, $item) {
        $carry .= implode("\t", $item) . "\n";
        return $carry;
    }, '');
}
