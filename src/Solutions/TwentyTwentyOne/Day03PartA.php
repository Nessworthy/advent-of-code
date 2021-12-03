<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day03PartA implements Solution
{

    public function solve(Input $input, Output $output): int|string
    {
        $columns = [];

        foreach ($input->readLine() as $line) {
            foreach (str_split($line) as $col => $digit) {
                if (!isset($columns[$col])) {
                    $columns[$col] = [0,0];
                }
                ++$columns[$col][(int) $digit];
            }
        }

        $gammaBinaryStr = '';
        $epsilonBinaryStr = '';

        foreach ($columns as $column) {
            $gammaBinaryStr .= ($column[0] > $column[1] ? '0' : '1');
            $epsilonBinaryStr .= ($column[0] > $column[1] ? '1' : '0');
        }

        $gammaRate = bindec($gammaBinaryStr);
        $epsilonRate = bindec($epsilonBinaryStr);

        return $gammaRate * $epsilonRate;
    }
}
