<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\TwentyTwentyOne\LanternFishCounter;

class Day06PartB implements Solution
{
    private LanternFishCounter $lanternFishCounter;

    public function __construct(LanternFishCounter $lanternFishCounter)
    {
        $this->lanternFishCounter = $lanternFishCounter;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $fish = array_map('toInt', explode(',', $input->readLine()->current()));
        return $this->lanternFishCounter->countFishAfterDays($fish, 256);
    }
}
