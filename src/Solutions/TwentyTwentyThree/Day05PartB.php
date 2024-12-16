<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyThree;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\NumberRange\NumberRange;
use Nessworthy\AoC\NumberRange\NumberRangeHelper;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyThree\Almanac;
use Nessworthy\AoC\TwentyTwentyThree\AlmanacLookup;

class Day05PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $almanac = new Almanac();
        $map = false;
        $seeds = [];

        foreach ($input->readLine() as $line) {
            if (str_starts_with($line, 'seeds: ')) {
                $seeds = array_map('toInt', explode(' ', substr($line, 7)));
                continue;
            }
            if ($line === '') {
                $map = false;
                continue;
            }
            if (!$map) {
                $matches = [];
                if (!preg_match('#^[a-z]+\-to\-([a-z]+)\ map:$#', $line, $matches)) {
                    throw new \RuntimeException('whoops - ' . $line);
                }

                $output->writeLine('New lookup: ' . $matches[1]);
                $map = new AlmanacLookup($matches[1]);
                $almanac->registerLookup($map);
                continue;
            }
            [$value, $from, $count] = array_map('toInt', explode(' ', $line));
            $output->writeLine('New range for ' . $map->getType() . ': ' . $from . '-' . $from + $count - 1 . ' -> ' . $value . '-' . $value + $count - 1);
            $map->registerLookup($from, $count, $value);
        }

        $min = false;

        // Convert seeds to range;
        for ($i = 0, $iMax = count($seeds); $i < $iMax; $i += 2) {
            $start =  $seeds[$i];
            $end = $start + $seeds[$i + 1] - 1;
            $output->writeLine('From ' . $start . ' to ' . $end);
        }

        $ranges = [new NumberRange(11, 5), new NumberRange(2,10)];

        var_dump(NumberRangeHelper::sortAndMerge(...$ranges));

        return 0;
    }
}
