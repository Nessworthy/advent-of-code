<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;

class Day04PartA implements Solution {
    private const PAPER_ROLL = '@';
    private const MAXIMUM_ADJACENT_ROLLS = 4;
    public function solve(Input $input, Output $output): int|string
    {
        $grid = Grid::fromInput($input);
        $totalAccessibleRolls = 0;

        $maximumCount = self::MAXIMUM_ADJACENT_ROLLS + 1; // Includes the center point!

        foreach ($grid->findAll(self::PAPER_ROLL) as $point) {
            // Get a 3x3 slice from the point.
            $slice = $grid->getSliceFromCenter($point);
            $foundRolls = 0;

            foreach ($slice->findAll(self::PAPER_ROLL) as $_slicePoint) {
                $foundRolls++;
                if ($foundRolls >= $maximumCount) {
                    break;
                }
            }

            if ($foundRolls < $maximumCount) {
                $totalAccessibleRolls++;
            }

        }
        return $totalAccessibleRolls;
    }
}
