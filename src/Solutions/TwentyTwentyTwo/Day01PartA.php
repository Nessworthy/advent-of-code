<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day01PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $elves = [];
        $currentElf = 0;
        foreach ($input->readLine() as $line) {
            if (empty($line)) {
                ++$currentElf;
            }
            if (!isset($elves[$currentElf])) {
                $elves[$currentElf] = 0;
            }
            $elves[$currentElf] += (int) $line;
        }

        return max($elves);
    }

}

