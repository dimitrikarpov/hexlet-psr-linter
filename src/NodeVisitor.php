<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;
use PsrLinter\Logger;
use PsrLinter\Checker;

class NodeVisitor extends NodeVisitorAbstract
{
    private $log;

    public function __construct()
    {
        $this->log = Logger::getInstance();
    }

    public function leaveNode(Node $node)
    {
        // Validate functions naming conventions
        if ($node instanceof \PhpParser\Node\Stmt\Function_) {
            $result = Checker::functionsNaming($node->name);
            if (is_array($result)) {
                $line = $node->getAttribute('startLine');
                $this->log->addError($line, $result['reason'], $result['type']);
            }
        }

        // Validate ... Another checker
    }
}
