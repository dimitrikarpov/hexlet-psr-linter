<?php

namespace PsrLinter;

use \Symfony\Component\Yaml\Yaml;

/**
 * Encode array of errors to string
 *
 * @param array $errors
 * @param string $format 'text', 'json' or 'yaml'
 *
 * @return string
 */
function report(array $errors, $format = 'text')
{
    switch ($format) {
        case 'text':
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

        case 'json':
            return json_encode($errors);

        case 'yaml':
            return Yaml::dump($errors);
    }
}
