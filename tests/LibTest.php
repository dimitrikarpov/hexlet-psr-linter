<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

class LibTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test parseException
     */
    public function testParseException()
    {
        require_once 'sniffs/VariablesNamingForCamelCase.php';
        $lint = makeLinter([new Rules\VariablesNamingForCamelCase()]);
        $this->expectException(ExceptionParse::class);
        $lint('<?php fun(t!0n');
    }
}
