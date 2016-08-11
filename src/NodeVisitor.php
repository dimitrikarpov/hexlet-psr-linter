<?php

namespace PsrLinter;

use \PhpParser\Node;
use \PhpParser\NodeVisitorAbstract;
use PsrLinter\Rules\FixersTemplate;

class NodeVisitor extends NodeVisitorAbstract
{
    private $rules = [];
    private $fixerEnabled;

    public function __construct(array $rules, $fixerEnabled)
    {
        $this->rules = $rules;
        $this->fixerEnabled = $fixerEnabled;
    }

    public function leaveNode(Node $node)
    {
        foreach ($this->rules as $checker) {
            $violationFound = $checker->check($node);
            if ($violationFound && $this->fixerEnabled && ($checker instanceof FixersTemplate)) {
                $checker->fix($node);
            }
        }
    }

    public function getErrors()
    {
        $errors = [];
        foreach ($this->rules as $checker) {
            $checkerErrors = $checker->getErrors();
            if ($checkerErrors) {
                $errors = array_merge($errors, $checkerErrors);
            }
        }

        return empty($errors) ? false : $errors;
    }
}
