<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyOne\HydrothermalVentRadar\VentRange;
use Nessworthy\AoC\TwentyTwentyOne\InputTransformer\HydrothermalVentRange;
use Nessworthy\AoC\TwentyTwentyOne\Visualizer\HydrothermalVentMap;

class Day05PartB implements Solution
{
    private HydrothermalVentMap $hydrothermalVentMap;
    private HydrothermalVentRange $hydrothermalVentRange;

    public function __construct(HydrothermalVentMap $hydrothermalVentMap, HydrothermalVentRange $hydrothermalVentRange)
    {
        $this->hydrothermalVentMap = $hydrothermalVentMap;
        $this->hydrothermalVentRange = $hydrothermalVentRange;
    }
    public function solve(Input $input, Output $output): int|string
    {
        $points = [];
        /** @var VentRange $ventRange */
        foreach ($this->hydrothermalVentRange->ventRangeGenerator($input) as $ventRange) {
            /** @var Point2D $point */
            foreach ($ventRange->pointInRangeGenerator() as $point) {
                $key = (string) $point;
                if (!isset($points[$key])) {
                    $points[$key] = 0;
                }
                ++$points[$key];
            }
        }

        $this->hydrothermalVentMap->visualize($points, $output);

        $greaterThanOne = static function (int $n) { return $n > 1; };

        return count(array_filter($points, $greaterThanOne));
    }
}
