<?php

namespace PsrLinter;

use PsrLinter\lint;
use PsrLinter\ExceptionParse;

class FunctionsNamingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test parseException
     */
    public function testParseException()
    {
        $this->expectException(ExceptionParse::class);
        lint('<?php fun(t!0n');
    }

    /**
     * Validate content of file functionsNaming.wrong.1.php according to camelCase rule
     */
    public function testWrong1()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.1.php');
        $errors = lint($code);
        $this->assertFalse(empty($errors));
    }
}
