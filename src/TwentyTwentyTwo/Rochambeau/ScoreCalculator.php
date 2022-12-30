<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\Rochambeau;

class ScoreCalculator {

    private $signScores = [
        Play::Rock->name => 1,
        Play::Paper->name => 2,
        Play::Scissors->name => 3
    ];

    private $resultScores = [
        Result::Win->name => [6,0],
        Result::Draw->name => [3,3],
        Result::Loss->name => [0,6],
    ];

    /**
     * @param string $theirPlay
     * @param string $yourPlay
     * @return int[]
     */
    public function calculateScores (Play $x, Play $y): array {

        $result = $this->getXVersusYResult(
            $x,
            $y
        );

        return [
            $this->resultScores[$result->name][0] + $this->signScores[$x->name],
            $this->resultScores[$result->name][1] + $this->signScores[$y->name]
        ];
    }

    private function getXVersusYResult(Play $x, Play $y): Result {
        if ($x === $y) {
            return Result::Draw;
        }

        if ($x === Play::Paper && $y === Play::Rock) {
            return Result::Win;
        }

        if ($x === Play::Rock && $y === Play::Scissors) {
            return Result::Win;
        }

        if ($x === Play::Scissors && $y === Play::Paper) {
            return Result::Win;
        }

        return Result::Loss;
    }

    public function determineSignToPlay(Play $theirHand, Result $yourDesiredResult) {

        if ($yourDesiredResult === Result::Draw) {
            return $theirHand;
        }

        if ($yourDesiredResult === Result::Win) {
            if ($theirHand === Play::Rock) {
                return Play::Paper;
            }

            if ($theirHand === Play::Scissors) {
                return Play::Rock;
            }

            return Play::Scissors;
        }

        if ($theirHand === Play::Rock) {
            return Play::Scissors;
        }

        if ($theirHand === Play::Scissors) {
            return Play::Paper;
        }

        return Play::Rock;

    }

}
