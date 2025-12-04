<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory\DiskMap;
use Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory\MemoryBlockAllocation;

class Day09PartA implements Solution {

    private DiskMap $diskMap;

    public function __construct(DiskMap $diskMap)
    {
        $this->diskMap = $diskMap;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $size = $input->getInputSize();
        $output->writeLine('Size of file is ' . $size);
        $checksum = 0;
        $block = 0;
        $readPosition = $size;
        $lastReadFileId = 0;

        $allocatableBlocks = $this->diskMap->getAllocatableBlocks($input, $size, true);

        for ($allocatePointer = 0; $allocatePointer < $size && $readPosition > $allocatePointer; $allocatePointer++) {
            $output->writeLine('Pointer is at pos ' . $allocatePointer);
            $isFile = $allocatePointer % 2 === 0;
            $value = $input->readAt($allocatePointer);
            if ($value === false) {
                throw new \RuntimeException('Read out of bounds at position ' . $allocatePointer);
            }
            if (!$isFile) {
                $output->writeLine('Position is allocatable space (' . $value . ' blocks)');
                // Allocate space.
                for (; $value > 0; $value--, $block++) {
                    // Find next allocated block from end.
                    /* @var $allocatable MemoryBlockAllocation */
                    $allocatable = $allocatableBlocks->current();
                    if ($allocatable->getPosition() <= $allocatePointer) {
                        $output->writeLine('Halting allocation of additional files, exhausted allocatable files.');
                        break 2;
                    }
                    $checksum += $block * $allocatable->getFileId();
                    $readPosition = $allocatable->getPosition();
                    $lastReadFileId = $allocatable->getFileId();
                    $output->writeLine('Allocating block from pos ' . $allocatable->getPosition() . ' (' . $allocatable->getSize() . ', ' . ($allocatable->getSize() - $allocatable->getBlock() - 1) . ' blocks remain)' . ' Checksum: ' . $checksum);
                    $allocatableBlocks->next();
                }
            } else {
                $output->writeLine('Position is a file (' . $value . ' blocks)');
                $fileId = $allocatePointer === 0 ? 0 : $allocatePointer / 2;
                for (; $value > 0; $value--, $block++) {
                    $checksum += $block * $fileId;
                }
            }
        }

        // Allocate the remaining blocks of the last read file
        $output->writeLine('Allocating remaining blocks of last scanned file (if any).');
        /* @var $remainingBlock MemoryBlockAllocation */
        for ($remainingBlock = $allocatableBlocks->current();
            $remainingBlock->getFileId() === $lastReadFileId;
            $allocatableBlocks->next(), $remainingBlock = $allocatableBlocks->current(), $block++) {
            $checksum += $block * $remainingBlock->getFileId();
            $output->writeLine('Allocating block from pos ' . $remainingBlock->getPosition() . ' (' . $remainingBlock->getSize() . ', ' . ($remainingBlock->getSize() - $remainingBlock->getBlock() - 1) . ' blocks remain)' . ' Checksum: ' . $checksum);
        }

        return $checksum;
    }
}
