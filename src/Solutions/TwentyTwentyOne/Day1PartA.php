<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day1PartA implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        return generator_reduce(
            $input->readLine(),
            static function($carry, $current) {
                $current = (int) $current;
                [$increments, $previous] = $carry;
                if ($current > $previous && !is_null($previous)) {
                    ++$increments;
                }
                return [$increments, $current];
            },
            [0, null]
        )[0];
    }
}
