<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day03PartB implements Solution
{

    public function solve(Input $input, Output $output): int|string
    {
        $firstDigit = $this->getCommonDigit($input->readLine(), 0);

        $oxygenGeneratorValues = [];
        $co2ScrubberValues = [];

        $input->reset();

        $columns = 0;

        foreach ($input->readLine() as $i => $line) {
            $columns = $columns || strlen($line);

            if ($line[0] === $firstDigit) {
                $oxygenGeneratorValues[] = $line;
            } else {
                $co2ScrubberValues[] = $line;
            }
        }

        for ($col = 2; $col <= $columns; ++$col) {
            if (count($oxygenGeneratorValues) === 1) {
                break;
            }
            $digit = $this->getCommonDigit($oxygenGeneratorValues, $col - 1);
            $curry = curry([$this, 'stringIndexMatchesValue'], $digit, $col - 1);
            $oxygenGeneratorValues = array_filter($oxygenGeneratorValues, $curry);
        }
        $oxygenGeneratorReading = bindec(array_pop($oxygenGeneratorValues));

        for ($col = 2; $col <= $columns; ++$col) {
            if (count($co2ScrubberValues) === 1) {
                break;
            }
            $digit = $this->getCommonDigit($co2ScrubberValues, $col - 1) === '0' ? '1' : '0';
            $curry = curry([$this, 'stringIndexMatchesValue'], $digit, $col - 1);
            $co2ScrubberValues = array_filter($co2ScrubberValues, $curry);
        }
        $co2ScrubberReading = bindec(array_pop($co2ScrubberValues));

        return $oxygenGeneratorReading * $co2ScrubberReading;
    }

    public function stringIndexMatchesValue(string $match, int $index, string $string): bool {
        return $string[$index] === $match;
    }

    private function getCommonDigit(iterable $array, int $column): string
    {
        $common = [0,0];
        foreach($array as $line) {
            ++$common[(int) $line[$column]];
        }
        return $common[0] > $common[1] ? '0' : '1';
    }
}
