<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result;

class NoMatch implements Result {
    public function matched(): bool
    {
        return false;
    }

    public function possibleMatches(): array
    {
        return [];
    }
}
