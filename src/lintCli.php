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
    $fixerEnabled = $options['fix'];
    $pathReport = $options['report-file'] ?? false;
    $reportFormat = $options['report-format'] ?? 'text';
    $sniffs = $options['sniffs'] ?? 'sniffs';

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

    $getRuleset = function ($path) {
        if ($path) {
            return json_decode(file_get_contents($path));
            // TODO: throw exception 'json not valid'
        } else {
            return false;
        }
    };

    $getRules = function ($sniffers, $ruleset) {
        $rules = [];

        foreach ($sniffers as $sniffer) {
            $pathinfo = pathinfo($sniffer);
            $rule     = $pathinfo['filename'];
            $className = "\\PsrLinter\\Rules\\$rule";

            if (!$ruleset) {
                include $sniffer;
                $rules[]  = new $className();
            } elseif (in_array($rule, $ruleset)) {
                include $sniffer;
                $rules[]  = new $className();
            }
        }

        return $rules;
    };

    $lintAndFix = function ($files, $rules) use ($fixerEnabled) {
        $lint = makeLinter($rules, $fixerEnabled);

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

    $rules = $getRules($getFiles($sniffs), $getRuleset($options['ruleset']));
    $files = $getFiles($path);
    $errors = $lintAndFix($files, $rules);

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
