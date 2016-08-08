<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;
use function PsrLinter\makeValidator;

class NodeVisitor extends NodeVisitorAbstract
{
    private $errors = [];

    public function leaveNode(Node $node)
    {
        $validate = makeValidator();
        $this->addErrors($validate($node));
    }

    public function addErrors($errors)
    {
        if (!empty($errors)) {
            $this->errors = array_merge($this->errors, $errors);
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
