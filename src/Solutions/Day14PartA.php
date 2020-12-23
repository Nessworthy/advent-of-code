<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class Day14PartA implements Solution
{
    public function execute(Input $input, Output $output): int|string
    {
        $memoryBank = [];
        $waxOn = 0;
        $waxOff = 0;

        foreach ($input->readLine() as $line) {
            if (str_starts_with($line, 'mask = ')) {
                $mask = substr($line, 7);
                $waxOn = bindec(
                    str_replace('X', '0', $mask)
                );
                $waxOff = ~ bindec(
                    str_replace(['X'], '1', $mask)
                );
                continue;
            }

            $matches = [];
            preg_match('#^mem\[(?<location>\d+)] = (?<value>\d+)$#', $line, $matches) or die('Well at least you know where it broke.');

            $location = (int) $matches['location'];
            $value = (int) $matches['value'];

            $value |= $waxOn;
            $value = ~(~$value | $waxOff);

            $memoryBank[$location] = $value;
        }

        return array_sum($memoryBank);
    }
}
