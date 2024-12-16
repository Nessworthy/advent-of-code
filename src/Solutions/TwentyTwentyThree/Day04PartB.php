<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day04PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $stack = [];

        foreach ($input->readLine() as $i => $line) {
            $stack[$i] = ($stack[$i] ?? 0) + 1;

            $stripped = explode(': ', $line)[1];
            [$winning, $actual] = explode(' | ', $stripped);
            $winningNumbers = array_filter(explode(' ', $winning));
            $actualNumbers = array_filter(explode(' ', $actual));

            $matching = array_intersect($actualNumbers, $winningNumbers);

            $matchingCount = count($matching);

            $output->writeLine('Card ' . $i + 1 . ': ' . ' has ' . $matchingCount . ' matching (' . $stack[$i] . ' copies)');

            for ($x = 1; $x <= $matchingCount; ++$x) {
                $card = $i + $x;
                // $output->writeLine('Adding ' . $stack[$i] . ' copies of card ' . $card + 1);
                $stack[$card] = ($stack[$card] ?? 0) + $stack[$i];
            }

        }

        return array_sum($stack);
    }
}
