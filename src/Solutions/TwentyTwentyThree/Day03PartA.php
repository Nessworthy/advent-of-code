<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Coordinates\Point2DHelper;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;

const NOTHING = '.';

class Day03PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $total = 0;
        $grid = new Grid(
            array_map(
                static fn ($line) => str_split($line),
                iterator_to_array($input->readLine())
            )
        );

        $numbers = [];
        $pointsToNumber = [];
        $symbols = [];

        $maxX = $grid->getWidth() - 1;
        $maxY = $grid->getHeight() - 1;

        foreach ($grid->getRows() as $y => $row) {

            $numberCapture = '';
            $numberPoints = [];

            /**
             * @var int $x
             * @var string $value
             */
            foreach ($row as $x => $value) {

                if (is_numeric($value)) {
                    $numberCapture .= $value;
                    $numberPoints[] = new Point2D($x, $y);
                }

                if ((!is_numeric($value) || $x === $maxX) && $numberCapture !== '') {
                    # Add number and points to register.
                    $index = count($numbers);
                    $numbers[] = (int) $numberCapture;
                    foreach ($numberPoints as $point) {
                        $pointsToNumber[$point->__toString()] = $index;
                    }
                    $output->writeLine('Captured ' . $numberCapture);
                    # Reset capture.
                    $numberPoints = [];
                    $numberCapture = '';
                }

                if (!is_numeric($value) && $value !== NOTHING) {
                    # Symbol capture.
                    $symbols[] = new Point2D($x, $y);
                }
            }
        }

        foreach ($symbols as $point) {
            $countedPoints = [];
            foreach (Point2DHelper::getNeighbouringPoints($point, 0, $maxX, 0, $maxY) as $neighbourPoint) {
                $key = $pointsToNumber[$neighbourPoint->__toString()] ?? null;
                if ($key === null || ($countedPoints[$key] ?? false) === true) {
                    continue;
                }
                $value = $numbers[$key];
                $countedPoints[$key] = true;
                $total += (int) $value;
                $output->writeLine('Symbol at ' . $point . ' sees ' . $value);
            }
        }

        return $total;
    }

}

