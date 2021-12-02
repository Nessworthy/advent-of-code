<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day7PartA implements Solution
{

    public function __construct()
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        $rules = [];
        $ruleCapture = '#^(?<modifier>\w+) (?<color>\w+) bags contain (?<contains>[^\.]+)\.$#';
        $containsCapture = '#^(?<quantity>\d+) (?<modifier>\w+) (?<color>\w+) bags?$#';
        foreach ($input->readLine() as $line)
        {
            $matches = [];
            preg_match($ruleCapture, $line, $matches);
            ['modifier' => $modifier, 'color' => $color, 'contains' => $contains] = $matches;
            $key = $modifier . ' ' . $color;

            if ($contains !== 'no other bags') {
                foreach (explode(', ', $contains) as $canBeContainedWithinBag) {
                    preg_match($containsCapture, $canBeContainedWithinBag, $matches);
                    ['modifier' => $containsModifier, 'color' => $containsColor, 'quantity' => $quantity] = $matches;
                    $bagCanContain = $containsModifier . ' ' . $containsColor;
                    $updatedRuleForBag = ($rules[$bagCanContain] ?? []);
                    $updatedRuleForBag[$key] = $quantity;
                    $rules[$bagCanContain] = $updatedRuleForBag;
                }
            }
        }

        $output->writeLine(sprintf('%d unique bag rules loaded', count($rules)));

        $seen = $this->recurseThroughSeenBags([], 'shiny gold', $rules);
        $output->writeLine((string) (count($seen)));
        return count($seen);
    }

    private function recurseThroughSeenBags(array $seen, string $current, &$rules): array
    {
        if (!isset($rules[$current]) || !$rules[$current]) {
            echo $current . ' -> (no bag can contain this)' . "\n";
            return $seen;
        }
        echo '[' . $current . ' -> ' . implode(', ', array_keys($rules[$current])) . "]\n";
        foreach ($rules[$current] as $child => $quantity) {
            if (isset($seen[$child])) {
                echo $current . ' -> ' . $child . " (seen) \n";
                continue;
            }
            $seen[$child] = true;
            echo $current . ' -> ' . $child . ' (' . count($seen) . ")\n";
            $seen = $this->recurseThroughSeenBags($seen, $child, $rules);
        }
        return $seen;
    }
}
