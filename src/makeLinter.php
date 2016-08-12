<?php

namespace PsrLinter;

use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use \PhpParser\ParserFactory;
use \PhpParser\PrettyPrinter;

function makeLinter(array $rules, $fixerEnabled = false)
{
    return function ($code) use ($rules, $fixerEnabled) {
        $parser    = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $visitor   = new NodeVisitor($rules, $fixerEnabled);
        $traverser = new \PhpParser\NodeTraverser();
        $traverser->addVisitor($visitor);

        try {
            $stmts = $parser->parse($code);
            $traverser->traverse($stmts);

            if ($fixerEnabled) {
                $prettyPrinter = new PrettyPrinter\Standard;
                return [
                    'fixedCode' => $prettyPrinter->prettyPrintFile($stmts),
                    'errors' => $visitor->getErrors()
                ];
            }

            return ['errors' => $visitor->getErrors()];
        } catch (\PhpParser\Error $e) {
            throw new ExceptionParse();
        }
    };
}
