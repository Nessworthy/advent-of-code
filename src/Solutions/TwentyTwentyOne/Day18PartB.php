<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\SnailMath\SnailMathOperations;
use Nessworthy\AoC\TwentyTwentyOne\SnailMath\SnailNumber;

class Day18PartB implements Solution
{
    private SnailMathOperations $snailMathOperations;

    public function __construct(SnailMathOperations $snailMathOperations)
    {
        $this->snailMathOperations = $snailMathOperations;
    }

    public function solve(Input $input, Output $output): int|string
    {
        /**
         * Dev notes:
         * At this point I'm about 7 hours into my COVID-19 booster and just feeling so dead.
         * So, screw it, let brute force lead the way.
         */

        $numbers = [];

        $most = 0;

        foreach($input->readLine() as $line) {
            $numbers[] = new SnailNumber($line);
        }

        foreach ($numbers as $leftIndex => $leftNumber) {
            foreach ($numbers as $rightIndex => $rightNumber) {
                $output->write($leftIndex . ' vs ' . $rightIndex . ': ');
                $result = $this->snailMathOperations->calculateMagnitude(
                    $this->snailMathOperations->sum($leftNumber, $rightNumber)
                );
                $output->write((string) $result);
                if ($result > $most) {
                    $most = $result;
                    $output->write(' (New highest!)');
                }
                $output->writeLine('');
            }
        }

        return $most;
    }
}
