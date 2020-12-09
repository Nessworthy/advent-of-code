<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Common;

class Output
{
    public function __construct(private $resource = STDOUT)
    {
    }

    public function write(string $str): void
    {
        fwrite($this->resource, $str);
    }

    public function writeLine(string $str): void
    {
        $this->write($str . "\n");
    }
}
