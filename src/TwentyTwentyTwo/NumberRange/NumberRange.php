<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\NumberRange;

class NumberRange {
    private int $from;
    private int $to;

    public function __construct(int $from, int $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function isCompletelyWithin(NumberRange $numberRange): bool {
        return $this->from >= $numberRange->getFrom() && $this->to <= $numberRange->getTo();
    }

    private function contains(int $number): bool {
        return $this->from <= $number && $this->to >= $number;
    }
    public function overlapsWith(NumberRange $numberRange): bool {
        return $this->contains($numberRange->from) || $this->contains($numberRange->to) || $this->isCompletelyWithin($numberRange);
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    public static function fromString(string $string): self {
        return new self(...array_map('toInt', explode('-', $string)));
    }
}
