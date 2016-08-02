<?php

namespace HexletPsrLinter;

use \PhpParser\ParserFactory;
use \PhpParser\Error;

/**
 * Linter class
 *
 * Class Linter
 *
 * @package HexletPsrLinter
 */
class Linter
{
    /**
     * Source code to lint
     *
     * @var string
     */
    private $code;

    /**
     * Is valid flag
     *
     * @var bool
     */
    private $isValid = false;

    private $stmts;

    /**
     * Constructor
     *
     * @param string $code code to validate
     */
    public function __construct($code)
    {
        $this->code = $code;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        try {
            $this->stmts = $parser->parse($this->code);
        } catch (\PhpParser\Error $e) {
            // 'Parse Error: ' . $e->getMessage();
        }
    }

    public function lint()
    {
        return $this->validate($this->stmts);
    }

    /**
     * Validate statement nodes
     *
     * @param array $stmts array of statement nodes
     *
     * @return string message
     */
    private function validate(array $stmts)
    {
        $this->isValid = true;

        if ($this->isValid) {
            return '';
        } else {
            return 'not valid';
        }
    }
}
