<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyTwo;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyTwo\NumberRange\NumberRange;

class Day04PartB implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        $matches = 0;

        foreach ($input->readLine() as $line) {
            /**
             * @var $firstRange NumberRange
             * @var $secondRange NumberRange
             */
            [$firstRange, $secondRange] = array_map([NumberRange::class, 'fromString'], explode(',', $line));

            $output->writeLine(sprintf(
                'First Range: %s to %s, Second Range: %s to %s',
                $firstRange->getFrom(),
                $firstRange->getTo(),
                $secondRange->getFrom(),
                $secondRange->getTo()
            ));

            if ($firstRange->overlapsWith($secondRange)) {
                ++$matches;
            }
        }

        return $matches;
    }
}

