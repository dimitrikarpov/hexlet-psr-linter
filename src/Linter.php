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

    public function __construct($code)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->stmts = $parser->parse($code);

        $this->traverser = new \PhpParser\NodeTraverser;
        $this->traverser->addVisitor(new NodeVisitor);
    }

    public function validate()
    {
        try {
            $this->traverser->traverse($this->stmts);
        } catch (\PhpParser\Error $e) {
            // TODO throw own exception
        }
        //return $this->assembleLog();
        //$log = Logger::getInstance();
        Reporter::stdout(Logger::getInstance());
    }

/*    private function assembleLog()
    {
        $log = Logger::getInstance();
        $found = $log->getLog();

        if (empty($found)) {
            return '';
        } else {
            return 'not valid'; // и тут вызвать что-то для показа предупреждений
        }
    }*/
}
