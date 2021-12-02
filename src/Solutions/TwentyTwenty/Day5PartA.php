<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\BinarySpacePartition;

class Day5PartA implements Solution
{
    public function __construct(private BinarySpacePartition $binarySpacePartition)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $highest = 0;
        foreach ($input->readLine() as $line) {
            $id = $this->binarySpacePartition->getSeatIdFromInstruction($line);
            if ($id > $highest) {
                $highest = $id;
            }
        }
        $output->write((string) $highest);
        return $highest;
    }
}
