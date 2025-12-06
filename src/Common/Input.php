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

    public function readCharacters(int $chunkSize = 1): Generator
    {
        while ($line = fgets($this->res, $chunkSize + 1)) {
            yield $line;
        }
    }

    public function reset(): void
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

    public function skipUntil(string $character): bool {
        for ($char = fgetc($this->res); $char !== false; $char = fgetc($this->res)) {
            if ($char === $character) {
                return true;
            }
        }
        return false;
    }

    public function skipCharacters(int $amount): bool {
        if ($amount === 0) {
            return true;
        }
        return !(fseek($this->res, $amount, SEEK_CUR));
    }

    public function readLastLine(): string {
        if (fseek($this->res, -1, SEEK_END) !== 0) {
            throw new \RuntimeException('Couldn\'t seek the EOF.');
        }

        $line = '';
        $char = fgetc($this->res);
        $offset = 0;

        while ($char !== "\n" && $char !== false) {
            $offset--;
            fseek($this->res, $offset, SEEK_END);
            $char = fgetc($this->res);
            $line .= $char;
        }
        return trim(strrev($line), "\n");
    }
}
