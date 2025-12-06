<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFive\Visualizer\PaperGrid;

class Day04PartB implements Solution {
    private const PAPER_ROLL = '@';
    private const EMPTY_SPACE = '_';
    private const MAXIMUM_ADJACENT_ROLLS = 4;
    private PaperGrid $paperGrid;

    public function __construct(PaperGrid $paperGrid)
    {
        $this->paperGrid = $paperGrid;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $grid = Grid::fromInput($input);

        $totalAccessibleRolls = 0;

        $maximumCount = self::MAXIMUM_ADJACENT_ROLLS + 1; // Includes the center point!

        $changeStack = [];

        foreach ($grid->findAll(self::PAPER_ROLL) as $matchPoint) {
            $changeStack[$matchPoint->__toString()] = $matchPoint;

            while (count($changeStack)) {
                $point = array_shift($changeStack);

                if ($grid->getByPoint($point) !== self::PAPER_ROLL) {
                    continue;
                }

                // Get a 3x3 slice from the point.
                $slice = $grid->getSliceFromCenter($point);

                $adjacentRolls = [];
                foreach ($slice->findAll(self::PAPER_ROLL) as $slicePoint) {
                    $adjacentRolls[] = $slicePoint;
                }

                if (count($adjacentRolls) < $maximumCount) {
                    // Update the grid, removing the current paper roll.
                    $grid = $grid->setValueAt($point, self::EMPTY_SPACE);

                    // Mark adjacent rolls as changed.
                    foreach ($adjacentRolls as $adjacentRoll) {
                        $absAdjacentRoll = $slice->getAbsolutePoint($adjacentRoll);
                        // Ignore the center point.
                        if ($absAdjacentRoll->is($point)) {
                            continue;
                        }
                        $changeStack[$absAdjacentRoll->__toString()] = $absAdjacentRoll;
                    }
                    $totalAccessibleRolls++;
                }
                // $this->paperGrid->display($grid, $changeStack, $point);
            }
        }

        return $totalAccessibleRolls;
    }
}
