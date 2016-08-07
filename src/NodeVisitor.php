<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;
use function PsrLinter\checkFunctionsNaming;

class NodeVisitor extends NodeVisitorAbstract
{
    private $errors = [];

    public function leaveNode(Node $node)
    {
        // Validate functions naming conventions
        if ($node instanceof \PhpParser\Node\Stmt\Function_) {
            $result = checkFunctionsNaming($node->name);
            if (is_array($result)) {
                $this->errors[] = [
                    'line'   => $node->getAttribute('startLine'),
                    'type'   => $result['type'],
                    'where'  => $result['where'],
                    'reason' => $result['reason']
                ];
            }
        }

        // Validate ... Another checker
    }

    /**
     * @return array|bool errors or false
     */
    public function getErrors()
    {
        return empty($this->errors) ? false : $this->errors;
    }
}
