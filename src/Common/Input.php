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

    public function readAt(int $position, bool $fromEnd = false): string|false {
        $res = fseek($this->res, $fromEnd ? $position * -1 : $position, $fromEnd ? SEEK_END : SEEK_SET);
        if ($res === -1) {
            throw new \RuntimeException('Cannot seek to an out of bounds position ' . $position . ($fromEnd ? ' from end' : ' from start'));
        }
        return fgetc($this->res);
    }

    public function getInputSize(): int {
        $stats = fstat($this->res);
        return $stats['size'];
    }

    public function readUntil(string $character, $includeCharacter = false): Generator {
        $chunk = '';
        for($char = fgetc($this->res); $char !== false; $char = fgetc($this->res)) {
            if ($char === $character) {
                yield $chunk . ($includeCharacter ? $char : '');
                $chunk = '';
                continue;
            }
            $chunk .= $char;
        }
        yield $chunk;
    }
}
