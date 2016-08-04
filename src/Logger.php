<?php

namespace PsrLinter;

class Logger
{
    protected static $instance;
    private $log = [];

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * Add report
     *
     * @param int $line
     * @param string $reason
     * @param string $type
     */
    public function addError($line, $reason, $type = 'error')
    {
        $this->log[] = ['line' => $line, 'reason' => $reason, 'type' => $type];
    }

    public function getLog()
    {
        return $this->log;
    }
}
