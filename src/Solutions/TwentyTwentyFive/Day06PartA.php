<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Solutions\TwentyTwentyFive;

use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\TwentyTwentyFive\TextTable\Column;

class Day06PartA implements Solution {
    public function solve(Input $input, Output $output): int|string
    {
        // Read last line
        $finalLine = $input->readLastLine();

        $columns = [];
        $columnOperator = [];
        $columnStart = false;

        foreach (str_split($finalLine) as $position => $char) {
            if ($char !== ' ') {
                if ($columnStart !== false) {
                    $columns[] = new Column($columnStart, $position - $columnStart - 1);
                }
                $columnStart = $position;
                $columnOperator[] = $char;
            }
        }

        // And the final column.
        $columns[] = new Column($columnStart ?: 0, -1);

        $columnCount = count($columns);
        $output->writeLine(sprintf('Identified %d columns', $columnCount));

        $columnSum = 0;
        $totalSum = 0;

        for ($currentColumnIndex = 0; $currentColumnIndex < $columnCount; $currentColumnIndex++) {
            $currentColumn = $columns[$currentColumnIndex];
            $input->reset();

            // While we have a line to read...
            $hasLine = true;

            $output->writeLine(sprintf('Column %d (pos %d, size: %d)', $currentColumnIndex + 1, $currentColumn->getPosition(), $currentColumn->getSize()));

            $row = 0;
            while ($hasLine) {
                if (!$input->skipCharacters($currentColumn->getPosition())) {
                    break;
                }

                if ($currentColumn->getSize() === -1) {
                    $value = $input->readLine()->current();
                } else {
                    $value = $input->readCharacters($currentColumn->getSize())->current();
                }
                $output->writeLine(sprintf('  Row %d: "%s"', $row + 1, $value));

                if (in_array($value[0], ['*', '+'])) {
                    break;
                }

                $valueInt = (int) trim($value);

                if ($row === 0) {
                    $columnSum = $valueInt;
                } else {
                    switch ($columnOperator[$currentColumnIndex]) {
                        case '*':
                            $columnSum *= $valueInt;
                            break;
                        case '+':
                            $columnSum += $valueInt;
                            break;
                        default:
                            throw new \RuntimeException('Should not have reached me!');
                    }
                }

                // Naff hack to fix the issue of the last column reading til EOL.
                if ($currentColumn->getSize() !== -1) {
                    $hasLine = $input->skipUntil("\n");
                }
                $row++;
                if ($row > 10) {
                    throw new \InvalidArgumentException("loop de loop");
                }
            }

            $output->writeLine('  Total: ' . $columnSum);
            $totalSum += $columnSum;
        }

        return $totalSum;
    }
}
