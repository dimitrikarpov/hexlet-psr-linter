<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract
{
    private $checkers = [];
    private $fixerEnabled;

    public function __construct($checkers, $fixerEnabled)
    {
        $this->checkers = $checkers;
        $this->fixerEnabled = $fixerEnabled;
    }

    public function leaveNode(Node $node)
    {
        foreach ($this->checkers as $checker) {
            $violation = $checker->check($node);
            if ($violation && $this->fixerEnabled && method_exists($checker, 'fix')) {
                $checker->fix($node);
            }
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
