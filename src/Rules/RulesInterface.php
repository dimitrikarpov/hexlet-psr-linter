<?php

namespace PsrLinter\Rules;

interface RulesInterface
{
    /**
     * @param \PhpParser\Node $node
     *
     * @return bool true if violation found
     */
    public function check(\PhpParser\Node $node);

    /**
     * @return mixed array or false in case of no violations found
     */
    public function getErrors();
}
