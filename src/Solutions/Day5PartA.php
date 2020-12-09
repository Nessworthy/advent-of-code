<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\BinarySpacePartition;

class Day5PartA implements Solution
{
    public function __construct(private BinarySpacePartition $binarySpacePartition)
    {
    }

    public function execute(Input $input, Output $output): void
    {
        $highest = 0;
        foreach ($input->readLine() as $line) {
            $id = $this->binarySpacePartition->getSeatIdFromInstruction($line);
            if ($id > $highest) {
                $highest = $id;
            }
        }
        $output->write((string) $highest);
    }
}
