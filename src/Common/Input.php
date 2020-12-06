<?php

namespace Nessworthy\AoC2020\Common;

class Input
{

    public function __construct(private string $filePath)
    {
    }

    public function readLine(): \Generator
    {
        $res = fopen($this->filePath, 'rb+');
        while ($line = fgets($res)) {
            $line = trim($line);
            yield $line;
        }
    }
}
