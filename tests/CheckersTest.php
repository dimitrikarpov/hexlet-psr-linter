<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

class CheckersTest extends \PHPUnit\Framework\TestCase
{
    public function testFunctionsNamingForCamelCaseWrong()
    {
        $code = file_get_contents('tests/fixtures/functionsNamingForCamelCase.wrong.php');

        $lint = makeLinter([new Checker\FunctionsNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testFunctionsNamingForCamelCaseRight()
    {
        $code = file_get_contents('tests/fixtures/functionsNamingForCamelCase.right.php');

        $lint = makeLinter([new Checker\FunctionsNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariablesNamingForCamelCaseWrong()
    {
        $code = file_get_contents('tests/fixtures/variablesNamingForCamelCase.wrong.php');

        $lint = makeLinter([new Checker\VariableNamingForCamelCase()], true);
        $linterReport = $lint($code);
        $actual = $linterReport['fixedCode'];
        $expected = file_get_contents('tests/fixtures/variablesNamingForCamelCase.right.php');

        $this->assertEquals($expected, $actual);
    }

    public function testVariablesNamingForCamelCaseRight()
    {
        $code = file_get_contents('tests/fixtures/variablesNamingForCamelCase.right.php');

        $lint = makeLinter([new Checker\VariableNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariableNamingForLeadingUnderscoreWrong()
    {
        $code = file_get_contents('tests/fixtures/variableNamingForLeadingUnderscore.wrong.php');

        $lint = makeLinter([new Checker\VariableNamingForLeadUnderscore()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testVariableNamingForLeadingUnderscoreRight()
    {
        $code = file_get_contents('tests/fixtures/variableNamingForLeadingUnderscore.right.php');
        
        $lint = makeLinter([new Checker\VariableNamingForLeadUnderscore()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/declarations.php');

        $lint = makeLinter([new Checker\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testSideEffectsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/sideEffects.php');

        $lint = makeLinter([new Checker\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsAndSideEffectsContainingFile()
    {
        $code = file_get_contents('tests/fixtures/declarationsAndSideEffects.php');

        $lint = makeLinter([new Checker\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }
}
