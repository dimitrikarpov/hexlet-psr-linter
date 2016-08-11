<?php

namespace PsrLinter\Rules;

class VariablesNamingForCamelCase extends FixersTemplate implements RulesInterface
{
    public function check(\PhpParser\Node $node)
    {
        if (( $node instanceof \PhpParser\Node\Expr\Variable ) &&
            (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name))
        ) {
            $this->addError($node, 'error', 'Names MUST be declared in camelCase.');

            return true;
        }
    }

    public function fix(\PhpParser\Node $node)
    {
        $camelize = function ($word) {
            $allWordsAreUpperCased = implode(array_map(function ($word) {
                return ucfirst(strtolower($word));
            }, explode('_', $word)));

            return lcfirst($allWordsAreUpperCased);
        };

        $node->name = $camelize($node->name);
    }
}
