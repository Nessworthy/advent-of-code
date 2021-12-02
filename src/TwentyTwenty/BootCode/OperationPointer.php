<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\BootCode;

class OperationPointer
{
    private int $pointer = 0;
    private int $nextPointer = 0;

    public function next(): int
    {
        $this->pointer = $this->nextPointer;
        $this->nextPointer = $this->pointer + 1;
        return $this->pointer;
    }

    public function moveRelative(int $relativeSteps): void
    {
        $this->nextPointer = $this->pointer + $relativeSteps;
    }

    public function moveAbsolute(int $absoluteStep): void
    {
        $this->nextPointer = $absoluteStep;
    }
}
