<?php

namespace PsrLinter\Rules;

class FunctionsNamingForCamelCase extends CheckersTemplate implements RulesInterface
{
    public function check(\PhpParser\Node $node)
    {
        if (($node instanceof \PhpParser\Node\Stmt\Function_) &&
            (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name))) {
            $this->addError($node, 'error', 'Method names MUST be declared in camelCase.');
        }
    }
}
