<?php

namespace PsrLinter\Rules;

interface RulesInterface
{
    public function check(\PhpParser\Node $node);
    public function getErrors();
}
