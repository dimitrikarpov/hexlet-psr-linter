<?php

namespace PsrLinter\Checker;

abstract class CheckerTemplate implements CheckerInterface
{
    protected $errors = [];

    public function __construct($fixerEnabled)
    {
        $this->fixerEnabled = $fixerEnabled;
    }

    abstract public function check(\PhpParser\Node $node);

    public function getErrors()
    {
        return empty($this->errors) ? false : $this->errors;
    }
}
