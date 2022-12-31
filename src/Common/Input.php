<?php declare(strict_types=1);

namespace Nessworthy\AoC\Common;

use Generator;

class Input
{
    /** @var resource */
    private $res;

    public function __construct(private string $filePath)
    {
        $res = fopen($this->filePath, 'rb+');
        $this->res = $res;
    }

    public function readLine(): Generator
    {
        while ($line = fgets($this->res)) {
            $line = rtrim($line, "\r\n");
            yield $line;
        }
    }

    public function readCharacters(int $chunkSize = 2): Generator
    {
        while ($line = fgets($this->res, $chunkSize)) {
            yield $line;
        }
    }

    public function reset()
    {
        fseek($this->res, 0);
    }
}
