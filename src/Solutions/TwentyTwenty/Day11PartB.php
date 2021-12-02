<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwenty\Grid\FerrySeats;
use Nessworthy\AoC\TwentyTwenty\Grid\FerrySeatsButWithEyes;

class Day11PartB implements Solution
{

    public function __construct(private FerrySeatsButWithEyes $ferrySeats)
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $this->ferrySeats->process($input, $output);
        return $this->ferrySeats->performPassUntilNobodyMoves();
    }
}
