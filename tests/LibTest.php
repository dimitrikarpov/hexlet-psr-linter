<?php

namespace PsrLinter;

use PsrLinter\Linter;
use PsrLinter\ExceptionParse;

class FunctionsNamingTest extends \PHPUnit\Framework\TestCase
{

    private $linter;

    public function setUp()
    {
        $this->linter = new Linter();
    }

    /**
     * Test parseException
     */
    public function testParseException()
    {
        $this->expectException(ExceptionParse::class);
        $this->linter->validate('<?php fun}[f');
    }

    /**
     * Validate content of file functionsNaming.wrong.1.php according to camelCase rule
     */
    public function testWrong1()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.1.php');
        $errors = $this->linter->validate($code);
        $this->assertFalse(empty($errors));
    }
}
