<?php

namespace PsrLinter;

use PsrLinter\linter;
use PsrLinter\ExceptionParse;

class FunctionsNamingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test parseException
     */
    public function testParseException()
    {
        $this->expectException(ExceptionParse::class);
        linter('<?php fun}[f');
    }

    /**
     * Validate content of file functionsNaming.wrong.1.php according to camelCase rule
     */
    public function testWrong1()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.1.php');
        $errors = linter($code);
        $this->assertFalse(empty($errors));
    }
}
