<?php

namespace Nessworthy\AoC2020\Grid;

use Generator;
use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class FerrySeatsButWithEyes extends FerrySeats
{
    private array $significantPositions = [];
    protected int $humanTolerance = 5;

    public function process(Input $input, Output $output): void
    {
        parent::process($input, $output);
        /** @noinspection AdditionOperationOnArraysInspection */
        $this->significantPositions = $this->filled + $this->empty;
    }

    private function getPositionUntilOutOfBounds(int $curX, int $curY, int $relY, int $relX): Generator
    {
        $curX += $relX;
        $curY += $relY;

        while ($curX >= 0 && $curY >= 0 && $curX < $this->width && $curY < $this->height) {
            yield ($curY * $this->width) + $curX;

            $curX += $relX;
            $curY += $relY;
        }
    }

    protected function getAdjacentPositions(int $index): Generator {

        $yPos = $index === 0 ? 0 : (int) floor($index / $this->width);
        $xPos = $index % $this->width;

        $increments = [
            'up' => [-1, 0],
            'down' => [1, 0],
            'left' => [0, -1],
            'right' => [0, 1],
            'up_left' => [-1, -1],
            'up_right' => [-1, 1],
            'down_left' => [1, -1],
            'down_right' => [1, 1]
        ];

        foreach ($increments as $increment) {
            foreach ($this->getPositionUntilOutOfBounds($xPos, $yPos, ...$increment) as $position) {
                // Only yield if it's a significant spot
                if (isset($this->significantPositions[$position])) {
                    yield $position;
                    break;
                }
            }
        }
    }
}
