<?php declare(strict_types=1);

namespace Nessworthy\AoC\Solutions\TwentyTwenty;

use Nessworthy\AoC\Solutions\Solution;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;

class Day7PartB implements Solution
{

    public function __construct()
    {
    }

    public function solve(Input $input, Output $output): int|string
    {
        /**
         * Node traversal & child count caching probably trumps all here,
         * but it's 10PM and I've just eaten take out,
         * so I'm not really with it.
         */
        $rules = [];
        $ruleCapture = '#^(?<modifier>\w+) (?<color>\w+) bags contain (?<contains>[^\.]+)\.$#';
        $containsCapture = '#^(?<quantity>\d+) (?<modifier>\w+) (?<color>\w+) bags?$#';
        foreach ($input->readLine() as $line)
        {
            $matches = [];
            preg_match($ruleCapture, $line, $matches);
            ['modifier' => $modifier, 'color' => $color, 'contains' => $contains] = $matches;
            $key = $modifier . ' ' . $color;

            $mustContain = [];

            if ($contains !== 'no other bags') {
                foreach (explode(', ', $contains) as $canBeContainedWithinBag) {
                    preg_match($containsCapture, $canBeContainedWithinBag, $matches);
                    ['modifier' => $containsModifier, 'color' => $containsColor, 'quantity' => $quantity] = $matches;
                    $childBagKey = $containsModifier . ' ' . $containsColor;
                    $mustContain[$childBagKey] = $quantity;
                }
            }

            $rules[$key] = $mustContain;
        }

        $output->writeLine(sprintf('%d unique bag rules loaded', count($rules)));

        $scores = [];
        $this->recurseThroughSeenBags([], 'shiny gold', $rules, $scores);
        $output->writeLine((string) ($scores['shiny gold']));
        return $scores['shiny gold'];
    }

    private function recurseThroughSeenBags(array $seen, string $current, &$rules, &$scores): array
    {
        $scores[$current] = 0;
        if (!isset($rules[$current]) || !$rules[$current]) {
            echo $current . ' -> (contains no bags)' . "\n";
            return $seen;
        }
        echo '[' . $current . ' -> ' . implode(', ', array_keys($rules[$current])) . "]\n";
        $score = 0;
        foreach ($rules[$current] as $child => $quantity) {
            if (isset($seen[$child])) {
                echo $current . ' -> ' . $child . " (seen: " . $scores[$child] . ") \n";
            } else {
                $seen[$child] = $quantity;
                $seen = $this->recurseThroughSeenBags($seen, $child, $rules, $scores);
                echo $current . ' -> ' . $child . ' (new: ' . $scores[$child] . ")\n";
            }
            $score += (1 + $scores[$child]) * $quantity;
        }
        $scores[$current] = $score;
        return $seen;
    }
}
