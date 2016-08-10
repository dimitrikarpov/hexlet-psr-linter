<?php

namespace PsrLinter;

use \PhpParser\ParserFactory;
use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use PsrLinter\Checker\SideEffect;

function lint($code)
{
    $checkers = [
        new Checker\FunctionsNamingForCamelCase(),
        new Checker\VariableNamingForCamelCase(),
        new Checker\VariableNamingForLeadUnderscore(),
        new Checker\SideEffect()
    ];

    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    $visitor = new NodeVisitor($checkers);
    $traverser = new \PhpParser\NodeTraverser;
    $traverser->addVisitor($visitor);

    try {
        $stmts = $parser->parse($code);
        $traverser->traverse($stmts);
    } catch (\PhpParser\Error $e) {
        throw new ExceptionParse();
    }

    return $visitor->getErrors();
}
