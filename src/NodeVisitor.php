<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;
use PsrLinter\Checker;

class NodeVisitor extends NodeVisitorAbstract
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function leaveNode(Node $node)
    {
        // Validate functions naming conventions
        if ($node instanceof \PhpParser\Node\Stmt\Function_) {
            $result = Checker::functionsNaming($node->name);
            if (is_array($result)) {
                $line = $node->getAttribute('startLine');
                $this->logger->addError($line, $result['reason'], $result['type']);
            }
        }

        // Validate ... Another checker
    }
}
