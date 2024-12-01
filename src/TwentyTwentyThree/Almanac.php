<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyThree;

class Almanac {

    /**
     * @var AlmanacLookup[]
     */
    private array $lookups = [];

    public function registerLookup(AlmanacLookup $lookup): void {
        $this->lookups[] = $lookup;
    }

    public function lookupValue(int $value): int {
        foreach ($this->lookups as $lookup) {
            $value = $lookup->lookupValue($value);
        }
        return $value;
    }
}
