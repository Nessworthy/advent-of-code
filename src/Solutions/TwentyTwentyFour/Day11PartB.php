<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFour;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFour\Stone\Stone;

class Day11PartB implements Solution {

    private $input = [
        ['a', 'b']
    ];

    private $alphabet = ['a', 'b' , 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u' ,'v', 'w', 'x', 'y', 'z'];

    private function core(int|float $current, array $next, array $operators): \Generator {
        if (count($next) === 0) {
            if ($current <= 0 || (int) $current != $current) {
                return;
            }
            yield $current;
        }

        $nextOne = array_shift($next);
        foreach ($operators as $i => $operator) {
            $others = array_merge(array_slice($operators, 0, $i), array_slice($operators, $i + 1));
            switch ($operator) {
                case '-':
                    yield from $this->core($current - $nextOne, $next, $others);
                    break;
                case '/':
                    yield from $this->core($current / $nextOne, $next, $others);
                    break;
                case '*':
                    yield from $this->core($current * $nextOne, $next, $others);
                    break;
            }
        }
    }

    public function solve(Input $input, Output $output): int|string
    {
        $stoneMap = [];
        $blinks = 75;

        foreach ($input->readUntil(' ') as $start) {
            if (!isset($stoneMap[(int) $start])) {
                $stoneMap[(int) $start] = 0;
            }
            $stoneMap[(int) $start]++;
        }

        for ($blink = 1; $blink <= $blinks; $blink++) {
            $nextStoneMap = [];
            foreach ($stoneMap as $stone => $count) {
                $stones = (new Stone($stone))->blink();
                foreach ($stones as $newStone) {
                    $val = $newStone->getValue();
                    if (!isset($nextStoneMap[$val])) {
                        $nextStoneMap[$val] = 0;
                    }
                    $nextStoneMap[$val] += $count;
                }
            }
            $stoneMap = $nextStoneMap;
        }
 
        return array_sum($stoneMap);
    }
}
