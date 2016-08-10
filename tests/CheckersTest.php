<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

class CheckersTest extends \PHPUnit\Framework\TestCase
{
    protected $lint;

    public function setUp()
    {
        $this->lint = makeLinter();
    }

    public function testFunctionsNamingWrong()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.php');
        $errors = $lint($code);
        $this->assertFalse(empty($errors));
    }

    public function testFunctionsNamingRight()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/functionsNaming.right.php');
        $errors = $lint($code);
        $this->assertFalse($errors);
    }

    public function testVariablesNamingWrong()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.php');
        $errors = $lint($code);
        $this->assertFalse(empty($errors));
    }

    public function testVariablesNamingRight()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/variablesNaming.right.php');
        $errors = $lint($code);
        $this->assertFalse($errors);
    }

    public function testDeclarationsOnlyFile()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/declarations.php');
        $errors = $lint($code);
        $this->assertFalse($errors);
    }

    public function testSideEffectsOnlyFile()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/sideEffects.php');
        $errors = $lint($code);
        $this->assertFalse($errors);
    }

    public function testDeclarationsAndSideEffectsContainingFile()
    {
        $lint = $this->lint;

        $code = file_get_contents('tests/fixtures/declarationsAndSideEffects.php');
        $errors = $lint($code);
        $this->assertFalse(empty($errors));
    }
}
