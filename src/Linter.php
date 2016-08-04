<?php

namespace PsrLinter;

use \PhpParser\ParserFactory;
use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use PsrLinter\NodeVisitor;
use PsrLinter\Logger;
use PsrLinter\Reporter;

class Linter
{
    private $stmts;
    private $traverser;
    private $logger;

    public function __construct($code)
    {
        $this->logger = Logger::getInstance();

        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->stmts = $parser->parse($code);

        $this->traverser = new \PhpParser\NodeTraverser;
        $this->traverser->addVisitor(new NodeVisitor($this->logger));
    }

    public function validate()
    {
        try {
            $this->traverser->traverse($this->stmts);
        } catch (\PhpParser\Error $e) {
            // TODO throw own exception
        }

        return $this->logger;
    }
}
