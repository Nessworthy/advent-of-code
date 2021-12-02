<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\ShipNavigation;

class Day12PartA implements Solution
{

    public function __construct(private ShipNavigation $shipNavigation)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        return (int) $this->shipNavigation->compute($input, $output);
    }
}
