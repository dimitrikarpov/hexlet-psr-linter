<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

/**
 * Command line interface fo Hexlet-PSR-Linter library
 *
 * Options array example:
 *
 * $options = [
 *   'rules' = [
 *       new Rules\FunctionsNamingForCamelCase(),
 *       new Rules\VariablesNamingForCamelCase(),
 *       new Rules\SideEffect()
 *   ],
 *   'fixerEnabled' => false
 * ];
 *
 * Errors array example:
 *
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
 * @param string $path file or directory to lint
 * @param array $options rules and fixerEnabled flag
 *
 * @return array|bool errors or false
 */
function lintCli($path, $options = [])
{
    $fixerEnabled = $options['fixerEnabled'] ?? false;
    $rules = $options['rules'] ?? [
            new Rules\FunctionsNamingForCamelCase(),
            new Rules\VariablesNamingForLeadUnderscore(),
            new Rules\VariablesNamingForCamelCase(),
            new Rules\SideEffect()
        ];

    $lint = makeLinter($rules, $fixerEnabled);

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

    $files = $getFiles($path);
    $errors = [];
    foreach ($files as $file) {
        $linterReport = $lint(file_get_contents($file));
        $fileErrors = $linterReport['errors'];
        if ($fileErrors) {
            $errors[$file] = $fileErrors;
        }

        if ($fixerEnabled) {
            $result = file_put_contents($file, $linterReport['fixedCode']);
            // TODO : write file exception if $result == false
        }
    }

    return empty($errors) ? false : $errors;
}
