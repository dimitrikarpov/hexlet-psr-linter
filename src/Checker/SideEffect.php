<?php

namespace PsrLinter\Checker;

class SideEffect extends CheckerTemplate implements CheckerInterface
{
    const DECLARATION = 'declaration';
    const SIDE_EFFECT = 'side effect';
    private $containsMixed = false;
    private $containsDeclarations = false;
    private $containsSideEffects = false;

    /**
     * Define what node actually do:
     * * declare new symbols (classes, functions, constants, etc.)
     * * or it execute logic with side effects
     *
     * @param $node
     *
     * @return string 'declaration' or 'side effect'
     */
    private function defineNode($node)
    {
        $definitions = [
            function ($node) {
                // for example: include 'file.php';
                if ($node instanceof \PhpParser\Node\Expr\Include_) {
                    return self::SIDE_EFFECT;
                }
            },
            function ($node) {
                // for example: ini_set('error_reporting', E_ALL);
                if (($node instanceof \PhpParser\Node\Expr\FuncCall) &&
                    ($node->name->parts[0] = 'ini_set')) {
                    return self::SIDE_EFFECT;
                }
            },
            function ($node) {
                // for example: echo "<html>\n";
                if ($node instanceof \PhpParser\Node\Stmt\Echo_) {
                    return self::SIDE_EFFECT;
                }
            },
            function ($node) {
                // for example: class Foo{}
                if ($node instanceof \PhpParser\Node\Stmt\Class_) {
                    return self::DECLARATION;
                }
            },
            function ($node) {
                // for example: function foo(){}
                if ($node instanceof \PhpParser\Node\Stmt\Function_) {
                    return self::DECLARATION;
                }
            },
            function ($node) {
                // for example: const FOO = '';
                if ($node instanceof \PhpParser\Node\Const_) {
                    return self::DECLARATION;
                }
            }
        ];

        foreach ($definitions as $define) {
            $definition = $define($node);
            if ($definition == self::DECLARATION || $definition == self::SIDE_EFFECT) {
                return $definition;
            }
        }
    }

    public function check(\PhpParser\Node $node)
    {
        if ($this->containsMixed) {
            return;
        }

        $definition = $this->defineNode($node);

        if ($definition == self::DECLARATION) {
            $this->containsDeclarations = true;
        } elseif ($definition == self::SIDE_EFFECT) {
            $this->containsSideEffects = true;
        }

        if ($this->containsSideEffects && $this->containsDeclarations) {
            $this->containsMixed = true;
            $this->errors[] = [
                'line'   => $node->getAttribute('startLine'),
                'type'   => 'error',
                'where'  => $definition,
                'reason' => 'A file SHOULD declare new symbols (classes, functions, constants, etc.) and cause no ' .
                            'other side effects, or it SHOULD execute logic with side effects, but SHOULD NOT do both.'
            ];
        }
    }
}
