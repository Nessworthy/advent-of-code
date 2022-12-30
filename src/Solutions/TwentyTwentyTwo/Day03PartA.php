<?php

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\Rucksack\Rucksack;

class Day03PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $value = 0;

        foreach ($input->readLine() as $line) {

            $rucksack = new Rucksack($line);

            $item = $rucksack->findOutOfPlaceItem();

            $output->writeLine($line . ' : ' . $item->getItem() . ' (' . $item->getValue() . ')');

            $value += $item->getValue();
        }

        return $value;
    }
}
