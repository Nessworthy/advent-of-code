<?php declare(strict_types=1);

namespace Nessworthy\AoC\NumberRange;

class NumberRange {
    private int $from;
    private int $to;
    public function __construct(int $from, int $to) {
        // We're not monsters here.
        $this->from = min($from, $to);
        $this->to = max($from, $to);
    }

    public function from(): int {
        return $this->from;
    }

    public function to(): int {
        return $this->to;
    }

    public function isInclusivelyBetween(int $number): bool {
        return $number >= $this->from && $number <= $this->to;
    }

    public function isExclusivelyBetween(int $number): bool {
        return $number > $this->from && $number < $this->to;
    }

    /**
     * Merging cleanly means to merge without including any
     * additional numbers outside the two given ranges.
     */
    public function canCleanlyMergeWith(NumberRange $range): bool {
        return $this->isInclusivelyBetween($range->from()) || $this->isInclusivelyBetween($range->to());
    }

    public function mergeWith(NumberRange $range): NumberRange {
        $collection = [$range->to(), $this->to, $range->from(), $this->from];
        return new NumberRange(min($collection), max($collection));
    }
}
