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
            $line = trim($line);
            yield $line;
        }
    }

    public function reset()
    {
        fseek($this->res, 0);
    }
}
