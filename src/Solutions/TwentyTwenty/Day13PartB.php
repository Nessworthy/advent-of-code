<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use JetBrains\PhpStorm\Pure;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day13PartB implements Solution
{
    private function removeOutOfServiceBusses($value): bool
    {
        return $value !== 'x';
    }

    #[Pure] private function calculateLowestT(array $numbers, array $remainders): int
    {
        $k = count($numbers);

        $product = array_product($numbers);

        $result = 0;

        for ($i = 0; $i < $k; $i++)
        {
            $pp = (int) $product / $numbers[$i];

            $result += $remainders[$i] * ((int) gmp_invert($pp, $numbers[$i])) * $pp;
        }

        return $result % $product;
    }

    public function solve(Input $input, Output $output): int|string
    {
        $lines = $input->readLine();

        $lines->next();
        $busses = explode(',', $lines->current());

        // Filter out busses with 'x' as they're out of service, or so we think.
        $busses = array_filter($busses, [$this, 'removeOutOfServiceBusses']);

        $remainders = [];
        $numbers = [];
        foreach ($busses as $index => $bus) {
            $numbers[] = $this->toInt($bus);
            $remainders[] = $index === 0 ? 0 : $bus - $index;
        }

        return $this->calculateLowestT(
            $numbers,
            $remainders
        );
    }

    private function toInt($x): int
    {
        return (int) $x;
    }
}
