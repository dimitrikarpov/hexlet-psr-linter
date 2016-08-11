<?php

namespace PsrLinter\Rules;

class FunctionsNamingForCamelCase extends RulesTemplate implements RulesInterface
{
    public function check(\PhpParser\Node $node)
    {
        if (($node instanceof \PhpParser\Node\Stmt\Function_) &&
            (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name))) {
            $this->errors[] = [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $node->name,
                'reason' => 'Method names MUST be declared in camelCase.'
            ];
        }
    }
}
