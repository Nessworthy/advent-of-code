<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\SnailMath;

class SnailNumber
{
    public const GATE_OPEN = '[';
    public const GATE_CLOSE = ']';
    public const NUMBER_SEP = ',';

    private string $stringRepresentation;

    public function __construct(string $stringRepresentation)
    {
        $this->stringRepresentation = $stringRepresentation;
    }

    public function __toString() {
        return $this->stringRepresentation;
    }
}
