<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Solutions\Solution;

class Day09PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $largestArea = 0;

        $points = [];

        foreach ($input->readLine() as $line) {
            $points[] = new Point2D(...array_map('toInt', explode(',', $line)));
        }

        $pointCount = count($points);

        foreach ($points as $outerIndex => $a) {
            for ($innerIndex = $outerIndex + 1; $innerIndex < $pointCount; $innerIndex++) {
                $b = $points[$innerIndex];
                $area = $a->getAreaBetween($b);
                $largestArea = max($largestArea, $area);
            }
        }

        return $largestArea;
    }
}
