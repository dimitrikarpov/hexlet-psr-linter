<?php

namespace PsrLinter;

function report($errors)
{
    $strings = array_map(function ($item) {
        return implode("\t", $item);
    }, $errors);

    return implode("\n", $strings);
}
