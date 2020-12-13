<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class Day10PartA implements Solution
{
    public function execute(Input $input, Output $output): int|string
    {
        $adapters = [];

        foreach ($input->readLine() as $line) {
            $adapters[] = (int) $line;
        }

        sort($adapters);

        $current = 0;
        $one = 0;
        $three = 0;

        foreach ($adapters as $adapter) {
            if ($adapter === $current + 1) {
                ++$one;
            } elseif ($adapter === $current + 3) {
                ++$three;
            }
            $current = $adapter;
        }
        ++$three;
        $output->writeLine('One: ' . $one);
        $output->writeLine('Three: ' . $three);
        return $one * $three;
    }

}
