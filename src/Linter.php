<?php

namespace PsrLinter;

use \PhpParser\ParserFactory;
use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use PsrLinter\NodeVisitor;
use PsrLinter\ExceptionParse;

class Linter
{
    private $stmts;
    private $traverser;

    public function validate($code)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        $this->traverser = new \PhpParser\NodeTraverser;
        $visitor = new NodeVisitor();
        $this->traverser->addVisitor($visitor);

        try {
            $this->stmts = $parser->parse($code);
            $this->traverser->traverse($this->stmts);
        } catch (\PhpParser\Error $e) {
            throw new ExceptionParse();
        }

        return $visitor->getErrors();
    }
}
