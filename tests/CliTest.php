<?php

namespace HexletPsrLinter;

class CliTest extends \PHPUnit\Framework\TestCase
{
    public function testSingleFile()
    {
        $this->assertEquals('', exec('./bin/hexlet-psr-linter tests/code.php'));
    }
}
