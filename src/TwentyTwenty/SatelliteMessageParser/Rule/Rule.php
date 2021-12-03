<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Rule;

use Nessworthy\AoC\TwentyTwenty\SatelliteMessageParser\Result\Result;

interface Rule {
    public function matches(string $string): Result;
}
