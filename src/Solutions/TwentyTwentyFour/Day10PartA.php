<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\InputAdapter;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Coordinates\Point2DHelper;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;

class Day10PartA implements Solution {
    private InputAdapter $inputAdapter;

    public function __construct(InputAdapter $inputAdapter)
    {
        $this->inputAdapter = $inputAdapter;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $grid = $this->inputAdapter->toGrid($input);

        $score = 0;

        foreach ($grid->findAll('0') as $point) {
            $output->writeLine('Found start at ' . $point);
            $points = count($this->getPaths($grid, $point, 0, $output));
            $output->writeLine('It has a score of ' . $points . '!');
            $score += $points;
        }

        return $score;
    }

    private function getPaths(Grid $grid, Point2D $currentPoint, int $currentElevation, Output $output): array {
        if ($currentElevation === 9) {
            return [$currentPoint->__toString() => true];
        }
        $nextElevation = $currentElevation + 1;
        $toMerge = [];
        foreach (Point2DHelper::getNeighbouringPoints(
            $currentPoint,
            0,
            $grid->getWidth() - 1,
            0,
            $grid->getHeight() - 1,
            true
        ) as $neighbouringPoint) {
            if ((int) $grid->getByPoint($neighbouringPoint) === $nextElevation) {
                $toMerge[] = $this->getPaths($grid, $neighbouringPoint, $nextElevation, $output);
            }
        }
        return array_merge(...$toMerge);
    }
}
