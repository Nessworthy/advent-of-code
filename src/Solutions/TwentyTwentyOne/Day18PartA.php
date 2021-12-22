<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\SnailMath\SnailMathOperations;
use Nessworthy\AoC\TwentyTwentyOne\SnailMath\SnailNumber;

class Day18PartA implements Solution
{
    private SnailMathOperations $snailMathOperations;

    public function __construct(SnailMathOperations $snailMathOperations)
    {
        $this->snailMathOperations = $snailMathOperations;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $line = $input->readLine();
        $left = new SnailNumber($line->current());
        $line->next();
        
        while ($sum = $line->current()) {
            $right = new SnailNumber($sum);
            $left = $this->snailMathOperations->sum($left, $right);
            $line->next();
        }

        $output->writeLine((string) $left);

        return $this->snailMathOperations->calculateMagnitude($left);
    }
}
