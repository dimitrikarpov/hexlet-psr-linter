<?php

namespace PsrLinter\Checker;

abstract class CheckerTemplate implements CheckerInterface
{
    protected $errors = [];

    abstract public function check(\PhpParser\Node $node);

    public function getErrors()
    {
        return empty($this->errors) ? false : $this->errors;
    }
}
