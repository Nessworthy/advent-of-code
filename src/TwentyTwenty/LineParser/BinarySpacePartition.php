<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\LineParser;

class BinarySpacePartition
{
    public function getSeatIdFromInstruction(string $partition): int
    {
        $binary = str_replace(['F', 'B', 'R', 'L'], ['0', '1', '1', '0'], $partition);
        $row = bindec(substr($binary, 0, 7));
        $column = bindec(substr($binary, 7, 3));
        return $row * 8 + $column;
    }
}
