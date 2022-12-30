<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\Rochambeau\Play;
use Nessworthy\AoC\TwentyTwentyTwo\Rochambeau\Result;
use Nessworthy\AoC\TwentyTwentyTwo\Rochambeau\ScoreCalculator;

class Day02PartB implements Solution {

    private $theirIndicators = [
        'A' => Play::Rock,
        'B' => Play::Paper,
        'C' => Play::Scissors,
    ];

    private $yourResult = [
        'X' => Result::Loss,
        'Y' => Result::Draw,
        'Z' => Result::Win,
    ];

    public function solve(Input $input, Output $output): int|string
    {
        $calculator = new ScoreCalculator();

        $score = 0;

        foreach ($input->readLine() as $line) {
            [$theirPlay, $yourDesiredResult] = explode(' ', $line);

            [$theirs, $yours] = $calculator->calculateScores(
                $this->theirIndicators[$theirPlay],
                $calculator->determineSignToPlay($this->theirIndicators[$theirPlay], $this->yourResult[$yourDesiredResult])
            );
            $output->writeLine($line . ' (' . $yours . ')');
            $score += $yours;
        }

        return $score;
    }
}
