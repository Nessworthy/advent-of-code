<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\LineParser\ShipBeaconNavigation;

class Day12PartB implements Solution
{

    public function __construct(private ShipBeaconNavigation $shipNavigation)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        return (int) $this->shipNavigation->compute($input, $output);
    }
}
