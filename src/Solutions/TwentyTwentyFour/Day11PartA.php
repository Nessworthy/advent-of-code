<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\Stone\Stone;

class Day11PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $totalStones = 0;

        foreach ($input->readUntil(' ') as $start) {
            $stones = [new Stone((int) $start)];

            for ($blink = 0; $blink < 25; $blink++) {
                $newStones = [];
                foreach ($stones as $stone) {
                    $newStones[] = $stone->blink();
                }
                $stones = array_merge(...$newStones);
            }

            $total =  count($stones);
            $output->writeLine("Stone $start ended up becoming $total stones.");
            $totalStones += $total;
        }
        return $totalStones;
    }
}
