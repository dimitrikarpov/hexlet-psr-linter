<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

class CheckersTest extends \PHPUnit\Framework\TestCase
{
    public function testFunctionsNamingForCamelCaseWrong()
    {
        $code = file_get_contents('tests/fixtures/functionsNamingForCamelCase.wrong.php');

        $lint = makeLinter([new Rules\FunctionsNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testFunctionsNamingForCamelCaseRight()
    {
        $code = file_get_contents('tests/fixtures/functionsNamingForCamelCase.right.php');

        $lint = makeLinter([new Rules\FunctionsNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariablesNamingForCamelCaseWrong()
    {
        $code = file_get_contents('tests/fixtures/variablesNamingForCamelCase.wrong.php');

        $lint = makeLinter([new Rules\VariablesNamingForCamelCase()], true);
        $linterReport = $lint($code);
        $actual = $linterReport['fixedCode'];
        $expected = file_get_contents('tests/fixtures/variablesNamingForCamelCase.right.php');

        $this->assertEquals($expected, $actual);
    }

    public function testVariablesNamingForCamelCaseRight()
    {
        $code = file_get_contents('tests/fixtures/variablesNamingForCamelCase.right.php');

        $lint = makeLinter([new Rules\VariablesNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariablesNamingForLeadingUnderscoreWrong()
    {
        $code = file_get_contents('tests/fixtures/variablesNamingForLeadingUnderscore.wrong.php');

        $lint = makeLinter([new Rules\VariablesNamingForLeadUnderscore()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testVariablesNamingForLeadingUnderscoreRight()
    {
        $code = file_get_contents('tests/fixtures/variablesNamingForLeadingUnderscore.right.php');

        $lint = makeLinter([new Rules\VariablesNamingForLeadUnderscore()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/declarations.php');

        $lint = makeLinter([new Rules\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testSideEffectsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/sideEffects.php');

        $lint = makeLinter([new Rules\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsAndSideEffectsContainingFile()
    {
        $code = file_get_contents('tests/fixtures/declarationsAndSideEffects.php');

        $lint = makeLinter([new Rules\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }
}