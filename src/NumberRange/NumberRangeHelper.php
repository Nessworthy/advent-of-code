<?php declare(strict_types=1);

namespace Nessworthy\AoC\NumberRange;

class NumberRangeHelper
{
    /**
     * @param NumberRange ...$ranges
     * @return NumberRange[]
     */
    public static function sortAndMerge(NumberRange ...$ranges): array {

        // Sort from lowest to highest.
        usort($ranges, fn (NumberRange $a, NumberRange $b) => $a->from() <=> $b->from());

        $changed = true;

        while ($changed) {
            $changed = false;
            foreach ($ranges as $i => $range) {
                w
            }
        }

        return $ranges;
    }
}
