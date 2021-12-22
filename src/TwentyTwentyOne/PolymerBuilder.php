<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne;

class PolymerBuilder {
    /**
     * Part 1 was first done by recursively passing the left + new, and right + new letters back into itself to generate
     * a total count. Worked a charm, but the time to execute was exponentially long, so was unsuitable to use in
     * part 2. Instead, part 2 saw this reworked to collect the number of times a pair appears in a step, find each new
     * letter for each pair, add the total count to the letter count, and repeat until max steps were reached.
     * @param string $string
     * @param array $rules
     * @param int $steps
     * @return array
     */
    public function buildAndFetchElementQuantities(string $string, array $rules, int $steps): array
    {

        // Start by collecting the pairs of letters.
        $limit = strlen($string) - 1;
        $letterCounts = array_count_values(str_split($string));

        $pairings = [];

        for ($i = 0; $i < $limit; ++$i) {
            $left = $string[$i];
            $right = $string[$i+1];
            $key = $left . $right;
            if (!isset($pairings[$key])) {
                $pairings[$key] = 0;
            }
            ++$pairings[$key];
        }

        $nextPairings = [];

        for ($step = 0; $step < $steps; ++$step) {
            foreach ($pairings as $pairing => $amount) {
                $next = $rules[$pairing];
                if (!isset($letterCounts[$next])) {
                    $letterCounts[$next] = 0;
                }
                $letterCounts[$next] += $amount;
                $left = $pairing[0] . $next;
                $right = $next . $pairing[1];
                foreach ([$left, $right] as $key) {
                    if (!isset($nextPairings[$key])) {
                        $nextPairings[$key] = 0;
                    }
                    $nextPairings[$key] += $amount;
                }
            }

            $pairings = $nextPairings;
            $nextPairings = [];
        }

        return $letterCounts;
    }
}
