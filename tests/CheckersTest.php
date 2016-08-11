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
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testFunctionsNamingRight()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.right.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariablesNamingWrong()
    {
        $code = file_get_contents('tests/fixtures/functionsNaming.wrong.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testVariablesNamingRight()
    {
        $code = file_get_contents('tests/fixtures/variablesNaming.right.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/declarations.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testSideEffectsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/sideEffects.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsAndSideEffectsContainingFile()
    {
        $code = file_get_contents('tests/fixtures/declarationsAndSideEffects.php');

        $lint = $this->lint;
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }
}
