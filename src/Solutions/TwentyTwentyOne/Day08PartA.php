<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day08PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $digitsMatching1478 = 0;
        foreach ($input->readLine() as $line) {
            [$signalPatterns, $outputValue] = explode(' | ', $line);
            $outputDigits = explode(' ', $outputValue);
            $digitsMatching1478 += array_reduce($outputDigits, static function($foundDigitCount, $digit) use ($output) {
                if (in_array(strlen($digit), [2,4,3,7])) {
                    ++$foundDigitCount;
                }
                return $foundDigitCount;
            });
        }

        return $digitsMatching1478;

    }
}
