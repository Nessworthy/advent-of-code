<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day06PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $charactersToIndex = [];
        $startIndex = 0;
        $length = 4;

        foreach ($input->readCharacters() as $index => $character) {
            $output->writeLine($character . ' (' . $index . ')');
            if (isset($charactersToIndex[$character]) && $charactersToIndex[$character] >= $startIndex) {
                $startIndex = $charactersToIndex[$character] + 1;

                $output->writeLine($character . ' appeared in pos ' . $charactersToIndex[$character] .  ' in last 4 letters (up to ' . $index . ')');
                $output->writeLine('SI is now ' . $startIndex);
            }

            $charactersToIndex[$character] = $index;

            if (($index - $startIndex) >= $length - 1) {
                return $index + 1;
            }
        }
        return -1;
    }

}
