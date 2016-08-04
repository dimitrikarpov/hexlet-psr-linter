<?php

namespace PsrLinter;

use PsrLinter\Linter;

class FunctionsNamingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * validate content of file functionsNaming.wrong.1.php according to camelCase rule
     */
    public function testWrong1()
    {
        $code = file_get_contents('tests/snippets/functionsNaming.wrong.1.php');
        $linter = new Linter($code);
        $errors = $linter->validate();
//        var_dump($errors);
//        exit;

        $this->assertFalse(empty($errors));
    }
}
