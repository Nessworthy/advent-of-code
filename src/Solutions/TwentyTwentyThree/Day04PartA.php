<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day04PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;

        foreach ($input->readLine() as $i => $line) {
            $stripped = explode(': ', $line)[1];
            [$winning, $actual] = explode(' | ', $stripped);
            $winningNumbers = array_filter(explode(' ', $winning));
            $actualNumbers = array_filter(explode(' ', $actual));

            $matching = array_intersect($actualNumbers, $winningNumbers);

            if (count($matching) === 0) {
                continue;
            }

            $score = 2 ** (count($matching) - 1);

            $output->writeLine($i + 1 . ': ' . count($matching) . ' matching for ' . $score . ' pts!');

            $total += $score;
        }

        return $total;
    }
}
