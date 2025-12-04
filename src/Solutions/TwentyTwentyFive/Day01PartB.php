<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day01PartB implements Solution {
    private const DIAL_SIZE = 100;

    public function solve(Input $input, Output $output): int|string
    {
        $currentPosition = 50;
        $timesAtZero = 0;

        foreach ($input->readLine() as $line) {
            $previousPosition = $currentPosition;
            $direction = $line[0];
            $amount = (int) substr($line, 1);

            $directionModifier = $direction === 'L' ? -1 : 1;

            // Turn the dial.
            $rawPosition = $currentPosition + $directionModifier * $amount;
            $currentPosition = $rawPosition % self::DIAL_SIZE;

            // Represent backwards = ... > 1 > 0 > 99 > ...
            if ($currentPosition < 0) {
                $currentPosition = 100 + $currentPosition;
            }

            // Times the dial passed zero.
            $timesPassedZero = (int) ($rawPosition >= 0
                ? floor($rawPosition / self::DIAL_SIZE)
                : ceil(abs($rawPosition / self::DIAL_SIZE)));

            // Case where the dial moves forward and ends up exactly on 00.
            // (Don't double count landing on 00)
            if ($rawPosition >= 0 && $timesPassedZero > 0 && $rawPosition % self::DIAL_SIZE === 0) {
                $timesPassedZero--;
            }
            // Case where the dial was on 00 and moves backwards.
            // (Don't count moving off 00 as passing 00)
            if ($previousPosition === 0 && $rawPosition < 0 && $timesPassedZero > 0) {
                $timesPassedZero--;
            }

            $timesAtZero += $timesPassedZero;

            // Case where position rests at zero.
            if ($currentPosition === 0) {
                ++$timesAtZero;
            }

            $output->writeLine(
                str_pad((string) $previousPosition, 2, '0', STR_PAD_LEFT)
                . " > "
                . str_pad($line, 3)
                . " = "
                . str_pad((string) $currentPosition, 2, '0')
                . ($timesPassedZero > 0 ? ' (+' . $timesPassedZero . ')' : '')
            );

        }
        return $timesAtZero;
    }
}
