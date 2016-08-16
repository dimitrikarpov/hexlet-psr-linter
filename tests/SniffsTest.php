<?php

namespace PsrLinter;

use function PsrLinter\makeLinter;

class CheckersTest extends \PHPUnit\Framework\TestCase
{
    public function testFunctionsNamingForCamelCaseWrong()
    {
        $code = file_get_contents('tests/fixtures/sniffs/functionsNamingForCamelCase.wrong.php');

        require_once 'sniffs/FunctionsNamingForCamelCase.php';
        $lint = makeLinter([new Rules\FunctionsNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testFunctionsNamingForCamelCaseRight()
    {
        $code = file_get_contents('tests/fixtures/sniffs/functionsNamingForCamelCase.right.php');

        require_once 'sniffs/FunctionsNamingForCamelCase.php';
        $lint = makeLinter([new Rules\FunctionsNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariablesNamingForCamelCaseWrong()
    {
        $code = file_get_contents('tests/fixtures/sniffs/variablesNamingForCamelCase.wrong.php');

        require_once 'sniffs/VariablesNamingForCamelCase.php';
        $lint = makeLinter([new Rules\VariablesNamingForCamelCase()], true);
        $linterReport = $lint($code);
        $actual = $linterReport['fixedCode'];
        $expected = file_get_contents('tests/fixtures/sniffs/variablesNamingForCamelCase.right.php');

        $this->assertEquals($expected, $actual);
    }

    public function testVariablesNamingForCamelCaseRight()
    {
        $code = file_get_contents('tests/fixtures/sniffs/variablesNamingForCamelCase.right.php');

        require_once 'sniffs/VariablesNamingForCamelCase.php';
        $lint = makeLinter([new Rules\VariablesNamingForCamelCase()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testVariablesNamingForLeadingUnderscoreWrong()
    {
        $code = file_get_contents('tests/fixtures/sniffs/variablesNamingForLeadingUnderscore.wrong.php');

        require_once 'sniffs/VariablesNamingForLeadUnderscore.php';
        $lint = makeLinter([new Rules\VariablesNamingForLeadUnderscore()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }

    public function testVariablesNamingForLeadingUnderscoreRight()
    {
        $code = file_get_contents('tests/fixtures/sniffs/variablesNamingForLeadingUnderscore.right.php');

        require_once 'sniffs/VariablesNamingForLeadUnderscore.php';
        $lint = makeLinter([new Rules\VariablesNamingForLeadUnderscore()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/sniffs/sideEffectsDeclarations.php');

        require_once 'sniffs/SideEffect.php';
        $lint = makeLinter([new Rules\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testSideEffectsOnlyFile()
    {
        $code = file_get_contents('tests/fixtures/sniffs/sideEffectsSideEffects.php');

        require_once 'sniffs/SideEffect.php';
        $lint = makeLinter([new Rules\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse($errors);
    }

    public function testDeclarationsAndSideEffectsContainingFile()
    {
        $code = file_get_contents('tests/fixtures/sniffs/sideEffectsDeclarationsAndSideEffects.php');

        require_once 'sniffs/SideEffect.php';
        $lint = makeLinter([new Rules\SideEffect()]);
        $linterReport = $lint($code);
        $errors = $linterReport['errors'];

        $this->assertFalse(empty($errors));
    }
}
