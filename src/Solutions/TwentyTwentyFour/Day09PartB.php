<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory\DiskMap;
use Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory\MemoryBlockAllocation;
use Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory\SpaceRegister;

class Day09PartB implements Solution {
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

        $spaceRegister = new SpaceRegister();
        $allocatableBlocks = $this->diskMap->getAllocatableBlocks($input, $size, false);
        $spaceBlocks = $this->diskMap->getAvailableSpaces($input, $size);
        $debug = [];
        $spacePositionPastBlockPosition = false;

        foreach ($allocatableBlocks as $block) {
            $output->writeLine('Found block ' . $block->getFileId() . ' of size ' . $block->getSize() . ' to allocate at position ' . $block->getPosition());
            $size = $block->getSize();
            $emptyBlockPosition = $spaceRegister->findAvailableSpace($size, $this->diskMap->getOriginalBlockForFileId($block->getFileId()));
            if ($emptyBlockPosition) {
                $output->writeLine('A space is already available at block ' . $emptyBlockPosition);
                $spaceRegister->allocateSpace($emptyBlockPosition, $size);
                $checksum += $this->calculateChecksum(new MemoryBlockAllocation(
                    $block->getFileId(),
                    $block->getSize(),
                    $block->getPosition(),
                    $emptyBlockPosition,
                ), $debug);
                continue;
            }
            if (!$spacePositionPastBlockPosition) {
                $output->writeLine('No spaces available yet, searching for open blocks...');
                // If no open position, wait until we find one.
                /** @var MemoryBlockAllocation $space */
                for ($space = $spaceBlocks->current(); $space; $spaceBlocks->next(), $space = $spaceBlocks->current()) {
                    $output->writeLine('Found open space of size ' . $space->getSize() . ' at position ' . $space->getBlock());
                    if ($space->getPosition() > $block->getPosition()) {
                        $spacePositionPastBlockPosition = true;
                        $output->writeLine('Skipping now and future space allocations because it\'s after current block position.');
                        break 1;
                    }
                    // Can we immediately allocate?
                    if ($space->getSize() >= $size) {
                        $output->writeLine('Let\'s immediately allocate this block to this space.');
                        $checksum += $this->calculateChecksum(new MemoryBlockAllocation(
                            $block->getFileId(),
                            $block->getSize(),
                            $block->getPosition(),
                            $space->getBlock(),
                        ), $debug);
                        $remaining = $space->getSize() - $size;
                        if ($remaining > 0) {
                            $output->writeLine('Registering remaining space of block size ' . $remaining . ' at block position ' . ($space->getBlock() + $size));
                            // Allocate remaining space
                            $spaceRegister->registerSpace($space->getBlock() + $size, $remaining);
                        }
                        // Stop looking for spaces.
                        // Since we're breaking, we need to move the pointer.
                        $spaceBlocks->next();
                        continue 2;
                    } else {
                        $output->writeLine('Registering for future use.');
                        // If not, register it for future use.
                        $spaceRegister->registerSpace($space->getBlock(), $space->getSize());
                    }
                }
                $output->writeLine('Could not find new space for block. Calculating checksum as-is.');
            } else {
                $output->writeLine('Skipping finding space because we\'d be allocating backwards.');
            }

            $amount = $this->calculateChecksum(new MemoryBlockAllocation(
                $block->getFileId(),
                $block->getSize(),
                $block->getPosition(),
                $this->diskMap->getOriginalBlockForFileId($block->getFileId())
            ), $debug);
            $output->writeLine('Adding ' . $amount . ' to checksum (now ' . ($checksum + $amount) . ')');
            $checksum += $amount;
        }

        ksort($debug, SORT_NUMERIC);
        $lastPosition = 0;
        foreach ($debug as $pos => $fileId) {
            while ($lastPosition < $pos) {
                $output->write('.');
                if ($lastPosition % 250 === 0) {
                    $output->write("\n");
                }
                $lastPosition++;
            }
            $output->write((string) ($fileId % 10));
            $lastPosition = $pos + 1;
            if ($pos % 250 === 0) {
                $output->write("\n");
            }
        }

        return $checksum;
    }

    private function calculateChecksum(MemoryBlockAllocation $block, &$debug): int {
        $total = 0;
        $blockPosition = $block->getBlock();
        $id = $block->getFileId();
        for ($remaining = $block->getSize(); $remaining > 0; $remaining-- ) {
            $total += $id * ($blockPosition + $remaining - 1);
            $debug[$blockPosition + $remaining - 1] = $id;
        }
        return $total;
    }
}
