<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

class LibTest extends \PHPUnit\Framework\TestCase
{
    protected $lint;

    public function setUp()
    {
        $this->lint = makeLinter();
    }

    /**
     * Test parseException
     */
    public function testParseException()
    {
        $lint = $this->lint;

        $this->expectException(ExceptionParse::class);
        $lint('<?php fun(t!0n');
    }
}
