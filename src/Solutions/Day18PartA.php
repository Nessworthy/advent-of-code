<?php declare(strict_types=1);

namespace Nessworthy\AoC2020\Solutions;

use Generator;
use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class Day18PartA implements Solution
{
    public function execute(Input $input, Output $output): int|string
    {
        $total = 0;
        foreach ($input->readLine() as $line) {
            $total += $this->calculateLine($line, $output);
        }
        return $total;
    }

    private function calculateLine(string|array $equation, Output $output): int
    {
        $current = 0;

        if (is_array($equation)) {
            $parts = $equation;
        } else {
            $parts = explode(' ', $equation);
        }

        $output->writeLine('Evaluating ' . implode(' ', $parts));

        $currentOperator = '+';

        while ($part = current($parts)) {
            if (in_array($part, ['+','*'])) {
                $currentOperator = $part;
            } else {
                if (str_starts_with($part, '(')) {
                    $subEquation = [];
                    $part = substr($part, 1);
                    $continue = true;
                    $depth = 1;
                    while ($continue) {

                        if (str_starts_with($part, '(')) {
                            $depth += strlen($part) - strlen(ltrim($part, '('));
                        }

                        if (str_ends_with($part, ')')) {
                            $depth -= strlen($part) - strlen(rtrim($part, ')'));
                            if ($depth === 0) {
                                $part = substr($part, 0, -1);
                                $continue = false;
                            }
                        }
                        $subEquation[] = $part;
                        if ($continue) {
                            $part = next($parts);
                        }
                    }

                    $part = $this->calculateLine($subEquation, $output);
                }
                $current = match ($currentOperator) {
                    '+' => $current + (int) $part,
                    '*' => $current * (int) $part
                };
            }
            next($parts);
        }
        return $current;
    }
}
