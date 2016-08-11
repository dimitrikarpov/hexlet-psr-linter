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
        $lint = makeLinter([new Rules\VariablesNamingForCamelCase()], false);

        $this->expectException(ExceptionParse::class);
        $lint('<?php fun(t!0n');
    }
}
