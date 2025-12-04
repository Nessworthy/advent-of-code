<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day01PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $pos = 50;
        $timesAtZero = 0;

        foreach ($input->readLine() as $line) {
            $prev = $pos;
            $dir = $line[0];
            $amount = (int) substr($line, 1);

            $dirMod = $dir === 'L' ? -1 : 1;

            // Turn the dial.
            $pos = ($pos + $dirMod * $amount) % 100;

            // Represent backwards = ... > 1 > 0 > 99 > ...
            if ($pos < 0) {
                $pos = 100 + $pos;
            }

            if ($pos === 0) {
                ++$timesAtZero;
            }

            $output->writeLine(
                str_pad((string) $prev, 2, '0', STR_PAD_LEFT)
                . " > "
                . str_pad($line, 3)
                . " = "
                . str_pad((string) $pos, 2, '0')
            );

        }
        return $timesAtZero;
    }
}
