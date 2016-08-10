<?php

namespace PsrLinter\Checker;

class VariableNamingForLeadUnderscore extends CheckerTemplate implements CheckerInterface
{
    public function check(\PhpParser\Node $node)
    {
        if (($node instanceof \PhpParser\Node\Expr\Variable ) &&
            (preg_match('/^_.+/', $node->name))) {
            $this->errors[] = [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $node->name,
                'reason' => "Property names SHOULD NOT be prefixed with a single " .
                            "underscore to indicate protected or private visibility."
            ];
        }
    }
}