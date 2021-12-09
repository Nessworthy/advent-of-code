<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyOne;

use Generator;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day09PartA implements Solution
{

    private array $buffer = [];

    public function solve(Input $input, Output $output): int|string
    {
        $lowPoints = 0;

        foreach ($this->heightMapBuffer($input->readLine()) as [$tile, $adjacentValues]) {
            if ($tile < min($adjacentValues)) {
                $output->writeLine($tile . ' is a lowpoint!');
                $lowPoints += $tile + 1;
            }
        }

        return $lowPoints;
    }

    private function heightMapBuffer(Generator $generator): Generator {

        // Reset the buffer.
        $this->buffer = [];

        $lengthOfCavern = 0;
        $firstLine = true;

        foreach ($generator as $line => $rowOfHeights) {

            $this->buffer[$line] = $rowOfHeights;

            if ($firstLine) {
                // Load the first line into the buffer.
                $lengthOfCavern = strlen($this->buffer[0]);
                $firstLine = false;
                continue;
            }

            yield from $this->generateAdjacentValues($line-1, $lengthOfCavern);

            if (count($this->buffer) === 3) {
                unset($this->buffer[array_key_first($this->buffer)]);
            }
        }

        // Generate last line's values.
        yield from $this->generateAdjacentValues(array_key_last($this->buffer), $lengthOfCavern);

    }

    private function generateAdjacentValues(int $line, int $lengthOfCavern): Generator {
        for ($col = 0; $col < $lengthOfCavern; ++$col) {
            $adjacentValues = [];

            if ($col > 0) {
                $adjacentValues[] = (int) $this->buffer[$line][$col-1];
            }
            if ($col < $lengthOfCavern - 1) {
                $adjacentValues[] = (int) $this->buffer[$line][$col+1];
            }
            if (isset($this->buffer[$line - 1])) {
                $adjacentValues[] = (int) $this->buffer[$line-1][$col];
            }
            if (isset($this->buffer[$line + 1])) {
                $adjacentValues[] = (int)$this->buffer[$line + 1][$col];
            }

            yield [
                (int) $this->buffer[$line][$col],
                $adjacentValues
            ];
        }
    }
}
