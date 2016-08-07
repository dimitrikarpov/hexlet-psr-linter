<?php

namespace PsrLinter;

/**
 * Encode array of errors to string
 *
 * @param array $errors
 *
 * @return string report
 */
function report($errors)
{
    $glueFileErrors = function ($fileErrors) {
        $strings = array_map(function ($item) {
            return implode("\t", $item);
        }, $fileErrors);

        return implode("\n", $strings);
    };

    $report = array_map(function ($file, $errors) use ($glueFileErrors) {
        return implode("\n", [$file, $glueFileErrors($errors)]);
    }, array_keys($errors), $errors);

    return implode("\n\n", $report);
}
