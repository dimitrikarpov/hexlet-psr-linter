<?php

namespace PsrLinter;

use PsrLinter\lint;

function lintDirectory($path)
{
    /**
     * @param string $path filename or directory
     *
     * @return array list of php files
     */
    $getFiles = function ($path) {
        if (is_dir($path)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            $regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

            return array_keys(iterator_to_array($regex));
        } else {
            return [$path];
        }
    };

    /**
     * getErrors
     *
     * Lint files and return array of founded errors according to these structure:
     * $errors = [
     * 'file.php' => [
     *          [ 'error', 'line', 'reason' ... ],
     *          [ 'warning', 'line', 'reason' ...],
     *  ],
     *  'file2.php' => [
     *          [ 'error', 'line', 'reason' ...],
     *          [ 'error', 'line', 'reason' ...],
     *  ],
     * .......
     * ];
     *
     * @param string $files
     *
     * @return bool|array list of founded errors or false
     */
    $getErrors = function ($files) {
        $allErrors = array_reduce($files, function ($carry, $item) {
            $errors = lint(file_get_contents($item));
            if ($errors) {
                $carry[$item] = $errors;
            }
            return $carry;
        }, []);

        return empty($allErrors) ? false : $allErrors;
    };

    return $getErrors($getFiles($path));
}
