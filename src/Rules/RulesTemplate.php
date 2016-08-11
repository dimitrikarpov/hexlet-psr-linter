<?php

namespace PsrLinter\Rules;

abstract class RulesTemplate implements RulesInterface
{
    protected $errors = [];

    abstract public function check(\PhpParser\Node $node);

    public function getErrors()
    {
        return empty($this->errors) ? false : $this->errors;
    }
}
