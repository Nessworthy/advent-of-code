<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\Rochambeau\Play;
use Nessworthy\AoC\TwentyTwentyTwo\Rochambeau\ScoreCalculator;

class Day02PartA implements Solution {

    private $theirIndicators = [
        'A' => Play::Rock,
        'B' => Play::Paper,
        'C' => Play::Scissors,
    ];

    private $yourIndicators = [
        'X' => Play::Rock,
        'Y' => Play::Paper,
        'Z' => Play::Scissors,
    ];

    public function solve(Input $input, Output $output): int|string
    {
        $calculator = new ScoreCalculator();

        $score = 0;

        foreach ($input->readLine() as $line) {
            [$theirPlay, $yourPlay] = explode(' ', $line);

            [$theirs, $yours] = $calculator->calculateScores($this->theirIndicators[$theirPlay], $this->yourIndicators[$yourPlay]);
            $output->writeLine($line . ' (' . $yours . ')');
            $score += $yours;
        }

        return $score;
    }
}
