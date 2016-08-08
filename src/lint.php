<?php

namespace PsrLinter;

use \PhpParser\ParserFactory;
use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use PsrLinter\NodeVisitor;
use PsrLinter\ExceptionParse;
use function PsrLinter\makeValidator;

function lint($code)
{
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    $visitor = new NodeVisitor();
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
