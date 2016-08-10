<?php

namespace PsrLinter;

use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use \PhpParser\ParserFactory;
use \PhpParser\PrettyPrinter;

function makeLinter($fixerEnabled = false)
{
    $checkers = [
        new Checker\FunctionsNamingForCamelCase($fixerEnabled),
        new Checker\VariableNamingForCamelCase($fixerEnabled),
        new Checker\VariableNamingForLeadUnderscore($fixerEnabled),
        new Checker\SideEffect($fixerEnabled)
    ];

    return function ($code) use ($checkers, $fixerEnabled) {
        $linterReport = [];

        $parser    = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $visitor   = new NodeVisitor($checkers);
        $traverser = new \PhpParser\NodeTraverser();
        $traverser->addVisitor($visitor);

        try {
            $stmts = $parser->parse($code);
            $traverser->traverse($stmts);

            if ($fixerEnabled) {
                $prettyPrinter = new PrettyPrinter\Standard;
                $linterReport['fixedCode'] = $prettyPrinter->prettyPrintFile($stmts);
            }
        } catch (\PhpParser\Error $e) {
            throw new ExceptionParse();
        }

        $linterReport['errors'] = $visitor->getErrors();

        return $linterReport;
    };
}
