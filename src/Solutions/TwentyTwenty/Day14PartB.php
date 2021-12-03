<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Generator;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Solutions\Solution;

class Day14PartB implements Solution
{
    public function solve(Input $input, Output $output): int|string
    {
        $memoryBank = [];
        $overwriteMask = 0;
        $floatingMask = 0;

        foreach ($input->readLine() as $line) {
            if (str_starts_with($line, 'mask = ')) {
                $mask = substr($line, 7);
                $overwriteMask = bindec(
                    str_replace('X', '0', $mask)
                );
                $floatingMask = bindec(
                    str_replace(['1', 'X'], ['0', '1'], $mask)
                );
                continue;
            }

            $matches = [];
            preg_match('#^mem\[(?<location>\d+)] = (?<value>\d+)$#', $line, $matches) or die('Well at least you know where it broke.');

            $location = (int) $matches['location'];
            $value = (int) $matches['value'];

            $location |= $overwriteMask;

            $output->writeLine('  Mask: ' . decbin($floatingMask));
            $output->writeLine('   Loc: ' . decbin($location) . ' (' . $location . ')');
            foreach ($this->generateAddressesFromFloatingMask($floatingMask, $location, $output) as $address) {
                $memoryBank[$address] = $value;
            }
        }

        return array_sum($memoryBank);
    }

    private function generateAddressesFromFloatingMask(int $floatingMask, int $value, Output $output, int $pointer = 1): Generator
    {
        while ($pointer <= $floatingMask) {

            if ($pointer & $floatingMask) {
                $newMask = $floatingMask - $pointer;
                // 0
                yield from $this->generateAddressesFromFloatingMask(
                    $newMask,
                    $value & ~$pointer,
                    $output,
                    $pointer << 1
                );

                // 1
                yield from $this->generateAddressesFromFloatingMask(
                    $newMask,
                    $value | $pointer,
                    $output,
                    $pointer << 1
                );

                return;
            }

            $pointer <<= 1;
        }

        $output->writeLine('        ' . str_pad(decbin($value), 6, '0', STR_PAD_LEFT) . ' (' . $value . ')');
        yield $value;
    }
}
