<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;
use function \PsrLinter\report;

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
 * @return integer exit code '0' for no errors and '1' if files have errors
 */
function lintCli($path, $options = [])
{
    $fixerEnabled = $options['fix'] ?? false;
    $pathReport = $options['report-file'] ?? false;
    $reportFormat = $options['report-format'] ?? 'text';
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

    $lintAndFix = function ($files) use ($lint, $fixerEnabled) {
        $errors = [];
        foreach ($files as $file) {
            $linterReport = $lint(file_get_contents($file));
            $fileErrors = $linterReport['errors'];
            if ($fileErrors) {
                $errors[$file] = $fileErrors;
            }

            if ($fixerEnabled) {
                file_put_contents($file, $linterReport['fixedCode']);
            }
        }

        return empty($errors) ? false : $errors;
    };

    $errors = $lintAndFix($getFiles($path));
    if ($errors && $pathReport) {
        file_put_contents('php://stderr', "Violations found. Report: {$pathReport}");
        file_put_contents($pathReport, report($errors, $reportFormat));
        return 1;
    } elseif ($errors) {
        file_put_contents('php://stderr', report($errors, $reportFormat));
        return 1;
    }

    return 0;
}
