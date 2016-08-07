<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;
use function PsrLinter\checkFunctionsNaming;
use function PsrLinter\checkVariableNaming;

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

        // Validate variable naming conventions
        if ($node instanceof \PhpParser\Node\Expr\Variable) {
            $result = checkVariableNaming($node->name);
            if (is_array($result)) {
                $this->errors[] = [
                    'line'   => $node->getAttribute('startLine'),
                    'type'   => $result['type'],
                    'where'  => $result['where'],
                    'reason' => $result['reason']
                ];
            }
        }
    }

    /**
     * @return array|bool errors or false
     */
    public function getErrors()
    {
        return empty($this->errors) ? false : $this->errors;
    }
}
