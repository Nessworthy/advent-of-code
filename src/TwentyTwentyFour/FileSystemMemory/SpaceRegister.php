<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory;

class SpaceRegister {
    private array $register = [];
    private int $maxSpace = 0;

    public function registerSpace (int $position, int $blockSize): void {
        $this->register[$position] = $blockSize;
        $this->maxSpace = max($this->maxSpace, $blockSize);
    }

    public function allocateSpace (int $position, int $blockSize): void {
        if (!isset($this->register[$position])) {
            throw new \RuntimeException('Not an allocatable space!');
        }
        // Remove from register
        $size = $this->register[$position];
        unset ($this->register[$position]);
        // Reduce remaining free space
        $remaining = $size - $blockSize;
        if ($remaining < 0) {
            throw new \RuntimeException('Tried to allocate more space to position than available!');
        }
        // Update register if needed.
        if ($remaining !== 0) {
            $this->register[$position + $blockSize] = $remaining;
            ksort($this->register, SORT_NUMERIC);
        }

        // Recalculate max space if needed.
        if ($this->maxSpace === $size) {
            $this->maxSpace = count($this->register) === 0 ? 0 : max($this->register);
        }
    }

    public function findAvailableSpace (int $blockSize, int $before = null): int|null {
        if ($this->maxSpace < $blockSize) {
            return null;
        }

        foreach ($this->register as $position => $size) {
            if ($before !== null && $position > $before) {
                return null;
            }
            if ($blockSize > $size) {
                continue;
            }
            return $position;
        }
        throw new \RuntimeException('Should be unreachable: Could not allocate size ' . $blockSize . ' despite max size being ' . $this->maxSpace);
    }
}