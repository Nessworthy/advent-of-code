<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\LineParser\ShipBeaconNavigation;

class Day12PartB implements Solution
{

    public function __construct(private ShipBeaconNavigation $shipNavigation)
    {
    }

    public function execute(Input $input, Output $output): int|string
    {
        return (int) $this->shipNavigation->compute($input, $output);
    }
}
