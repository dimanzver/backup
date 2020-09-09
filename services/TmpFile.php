<?php


namespace app\services;


class TmpFile
{
    private $filename;

    public function __construct($prefix)
    {
        $this->filename = tempnam(sys_get_temp_dir(), $prefix);

        if (!$this->filename) {
            throw new \RuntimeException("tempnam() couldn't create a temp file");
        }

        pcntl_async_signals(true);
        register_shutdown_function([$this, 'unlink']);
        pcntl_signal(SIGTERM, [$this, 'unlink']);
        pcntl_signal(SIGINT, [$this, 'unlink']);
    }

    public function __toString(): string
    {
        return $this->filename;
    }

    public function unlink() {
        if (file_exists($this->filename)) {
            unlink($this->filename);
        }
    }
}