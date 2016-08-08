<?php

namespace PsrLinter;

use function PsrLinter\getCheckers;

function getCheckers()
{
    $checkFunctionsNamingForCamelCase = function (\PhpParser\Node $node) {
        if (!$node instanceof \PhpParser\Node\Stmt\Function_) {
            return false;
        }

        if (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name)) {
            return [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $node->name,
                'reason' => 'Method names MUST be declared in camelCase.'
            ];
        }

        return false;
    };

    $checkVariableNamingForLeadUnderscore = function (\PhpParser\Node $node) {
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return false;
        }

        if (preg_match('/^_.+/', $node->name)) {
            return [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $node->name,
                'reason' => "Property names SHOULD NOT be prefixed with a single " .
                            "underscore to indicate protected or private visibility."
            ];
        }

        return false;
    };

    $checkVariableNamingForCamelCase = function (\PhpParser\Node $node) {
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return false;
        }

        if (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name)) {
            return [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $node->name,
                'reason' => 'Method names MUST be declared in camelCase.'
            ];
        }

        return false;
    };

    return [
        $checkFunctionsNamingForCamelCase,
        $checkVariableNamingForLeadUnderscore,
        $checkVariableNamingForCamelCase
    ];
}
