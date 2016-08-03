<?php

namespace HexletPsrLinter;

use \PhpParser\ParserFactory;
use \PhpParser\Error;
use \PhpParser\NodeTraverser;
use HexletPsrLinter\LinterNodeVisitor;
use HexletPsrLinter\LinterLog;
use HexletPsrLinter\Reporter;

class Linter
{
    private $stmts;
    private $traverser;

    public function __construct($code)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->stmts = $parser->parse($code);

        $this->traverser = new \PhpParser\NodeTraverser;
        $this->traverser->addVisitor(new LinterNodeVisitor);
    }

    public function validate()
    {
        try {
            $this->traverser->traverse($this->stmts);
        } catch (\PhpParser\Error $e) {
            // TODO throw own exception
        }
        //return $this->assembleLog();
        //$log = LinterLog::getInstance();
        Reporter::stdout(LinterLog::getInstance());
    }

/*    private function assembleLog()
    {
        $log = LinterLog::getInstance();
        $found = $log->getLog();

        if (empty($found)) {
            return '';
        } else {
            return 'not valid'; // и тут вызвать что-то для показа предупреждений
        }
    }*/
}
