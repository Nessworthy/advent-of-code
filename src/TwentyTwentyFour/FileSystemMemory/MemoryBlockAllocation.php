<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory;

class MemoryBlockAllocation {
    private int $fileId;
    private int $size;
    private int $position;
    private int $block;

    public function __construct(int $fileId, int $size, int $position, int $block)
    {
        $this->fileId = $fileId;
        $this->size = $size;
        $this->position = $position;
        $this->block = $block;
    }

    public function getBlock(): int
    {
        return $this->block;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getFileId(): int
    {
        return $this->fileId;
    }
}