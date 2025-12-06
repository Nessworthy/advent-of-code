<?php declare(strict_types = 1);

namespace Nessworthy\AoC\TwentyTwentyFive\TextTable;

class Column {
    private int $position;
    private int $size;

    public function __construct(int $position, int $size) {
        $this->position = $position;
        $this->size = $size;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}