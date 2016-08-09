<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract
{
    private $checkers = [];

    public function __construct($checkers)
    {
        $this->checkers = $checkers;
    }

    public function leaveNode(Node $node)
    {
        foreach ($this->checkers as $checker) {
            $checker->check($node);
        }
    }

    public function getErrors()
    {
        $errors = [];
        foreach ($this->checkers as $checker) {
            $checkerErrors = $checker->getErrors();
            if ($checkerErrors) {
                $errors = array_merge($errors, $checkerErrors);
            }
        }

        return empty($errors) ? false : $errors;
    }
}
