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
                    $fixable = $item['fixable'] ? '[x]' : '[ ]';
                    $format = "%' 4d\t%' 9s\t%s\t%s\t%s";
                    return sprintf($format, $item['line'], $item['type'], $fixable, $item['where'], $item['reason']);
                }, $fileErrors);

                return implode("\n", $strings);
            };

            $report = array_map(function ($file, $errors) use ($glueFileErrors) {
                return implode("\n", [$file, $glueFileErrors($errors)]);
            }, array_keys($errors), $errors);

            $footer = "PSR-LINTER CAN FIX MARKED SNIFF VIOLATIONS AUTOMATICALLY\n";
            $report[] = $footer;

            return implode("\n\n", $report);

        case 'json':
            return json_encode($errors);

        case 'yaml':
            return Yaml::dump($errors);
    }
}
