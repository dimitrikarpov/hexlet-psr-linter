<?php

namespace PsrLinter;

function report($errors)
{
    return implode("\n", array_map(function ($item) {
        return implode("\t", $item);
    }, $errors));
}
