<?php

namespace PsrLinter\Checker;

class VariableNamingForCamelCase extends CheckerTemplate implements CheckerInterface
{
    public function check(\PhpParser\Node $node)
    {
        if (( $node instanceof \PhpParser\Node\Expr\Variable ) &&
            (!preg_match('/^[a-z]+([A-Z]?[a-z]+)+$/', $node->name))
        ) {
            $this->errors[] = [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $node->name,
                'reason' => 'Names MUST be declared in camelCase.'
            ];

            if ($this->fixerEnabled) {
                $this->fix($node);
            }
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
