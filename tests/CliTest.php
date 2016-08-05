<?php

namespace PsrLinter;

class CliTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidArguments()
    {
        $this->assertEquals(1, preg_match("/ERROR/", exec('./bin/psr-linter')));
    }

    public function testCheckValidFile()
    {
        exec('./bin/psr-linter tests/snippets/valid.php', $output, $return_var);
        $this->assertEquals(0, $return_var);
    }
}
