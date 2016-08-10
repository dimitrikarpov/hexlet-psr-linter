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
     * Validate content of file functionsNaming.wrong.php according to camelCase rule
     */
    public function testFunctionsNamingWrong()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.php');
        $errors = lint($code);
        $this->assertFalse(empty($errors));
    }

    /**
     * Validate content of file functionsNaming.right.php according to camelCase rule
     */
    public function testFunctionsNamingRight()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.right.php');
        $errors = lint($code);
        $this->assertFalse($errors);
    }

    /**
     * Validate content of file variablesNaming.right.php according to first underscore rule
     */
    public function testVariablesNamingRight()
    {
        $code = file_get_contents('tests/fixtures/variablesNaming.right.php');
        $errors = lint($code);
        $this->assertFalse($errors);
    }

    /**
     * Validate content of file functionsNaming.wrong.php according to first underscore rule
     */
    public function testVariablesNamingWrong()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.php');
        $errors = lint($code);
        $this->assertFalse(empty($errors));
    }

    public function testDeclarationsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/declarations.php');
        $errors = lint($code);
        $this->assertFalse($errors);
    }

    public function testSideEffectsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/sideEffects.php');
        $errors = lint($code);
        $this->assertFalse($errors);
    }

    public function testDeclarationsAndSideEffectsContainingFile()
    {
        $code = file_get_contents('tests/fixtures/declarationsAndSideEffects.php');
        $errors = lint($code);
        $this->assertFalse(empty($errors));
    }
}
