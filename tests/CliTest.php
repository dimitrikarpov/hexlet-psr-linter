<?php

namespace PsrLinter;

class CliTest extends \PHPUnit\Framework\TestCase
{
    public function testNoArguments()
    {
        $result = exec('./bin/psr-linter');
        $this->assertEquals('Usage: psr-linter filename', $result);
    }

    public function testPathNotExists()
    {
        $result = exec('./bin/psr-linter code.php');
        $this->assertEquals('Usage: psr-linter filename', $result);
    }

    public function testFileValid()
    {
        exec('./bin/psr-linter tests/snippets/valid.php', $output, $return_var);
        $this->assertEquals(0, $return_var);
    }

    public function testFileNotValid()
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );

        $cmd = './bin/psr-linter tests/snippets/functionsNaming.php';
        $process = proc_open($cmd, $descriptorspec, $pipes, null, null);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        proc_close($process);
        $this->assertFalse(empty($stderr));
    }
}
