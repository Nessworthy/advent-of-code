<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\Grid\FerrySeats;

class Day11PartA implements Solution
{

    public function __construct(private FerrySeats $ferrySeats)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $this->ferrySeats->process($input, $output);
        return $this->ferrySeats->performPassUntilNobodyMoves();
    }
}
