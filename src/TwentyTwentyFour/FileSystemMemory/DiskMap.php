<?php declare(strict_types = 1);

namespace Nessworthy\AoC\TwentyTwentyFour\FileSystemMemory;

use Nessworthy\AoC\Common\Input;

class DiskMap {

    private $blockCache = [];

    /**
     * Scans from the end of the diskmap string and yields memory block allocations,
     * for the disk memory allocator to re-allocate.
     * @param Input $input
     * @param int $size
     * @param bool $singleBlockAllocation If true, yields single file blocks for allocation.
     *                                    Else, yields entire file blocks.
     * @return \Generator
     */
    public function getAllocatableBlocks(Input $input, int $size, bool $singleBlockAllocation): \Generator {
        $maxFileIds = toInt(ceil($size / 2));
        $endsOnFileId = $size === $maxFileIds * 2;
        $pointerOffset = $endsOnFileId ? 0 : -1;

        $pointer = $pointerOffset;
        $currentFileId = $maxFileIds;
        while ($pointer < $size) {
            $pointer += 2;
            $currentFileId--;
            $value = $input->readAt($pointer, true);

            if ($singleBlockAllocation) {
                for ($i = 0; $i < $value; $i++) {
                    yield new MemoryBlockAllocation(
                        $currentFileId,
                        (int) $value,
                        $size - $pointer,
                        $i
                    );
                }
            } else {
                yield new MemoryBlockAllocation(
                    $currentFileId,
                    (int) $value,
                    $size - $pointer,
                    0
                );
            }
        }
    }

    public function getAvailableSpaces(Input $input, int $diskMapSize): \Generator {
        $block = 0; // Block space in the file system.
        $position = 0; // Pointer position in the disk map input.
        while ($position < $diskMapSize) {
            $size = (int) $input->readAt($position);
            $isFile = $position % 2 === 0;
            if (!$isFile) {
                // echo "Yielding open space of {$size} at $position and block position $block" . "\n";
                yield new MemoryBlockAllocation(
                    -1,
                    $size,
                    $position,
                    $block
                );
            } else {
                $fileId = $position === 0 ? 0 : (int) ($position / 2);
                $this->blockCache[$fileId] = $block;
            }

            $block += $size;
            $position++;
        }
    }

    public function getOriginalBlockForFileId(int $fileId): int|null {
        return $this->blockCache[$fileId] ?? null;
    }
}