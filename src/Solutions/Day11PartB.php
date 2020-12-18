<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\Grid\FerrySeats;
use Nessworthy\AoC2020\Grid\FerrySeatsButWithEyes;

class Day11PartB implements Solution
{

    public function __construct(private FerrySeatsButWithEyes $ferrySeats)
    {
    }

    public function execute(Input $input, Output $output): int|string
    {
        $this->ferrySeats->process($input, $output);
        return $this->ferrySeats->performPassUntilNobodyMoves();
    }
}
