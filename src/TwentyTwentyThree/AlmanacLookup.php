<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyThree;

class AlmanacLookup {
    private string $type;
    private array $register = [];

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function registerLookup(int $start, int $count, int $response): void {
        $this->register[$start] = ['to' => $start + $count - 1, 'response' => $response];
        krsort($this->register);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function lookupValue(int $value): int {

        foreach ($this->register as $min => $conf) {
            if ($min > $value) {
                continue;
            }

            if ($value <= $this->register[$min]['to']) {
                $offset = $value - $min;
                $mappedValue = $this->register[$min]['response'] + $offset;
                return $mappedValue;
            }
        }

        return $value;
    }
}
