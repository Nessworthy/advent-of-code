<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFour\Stone;

class Stone {
    private int $value;
    private int $blinked;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return Stone[]
     */
    public function blink(): array {
        if ($this->value === 0) {
            return [new Stone(1)];
        }
        $asStr = (string) $this->value;
        $length = strlen($asStr);
        if (strlen($asStr) % 2 === 0) {
            $parts = str_split($asStr, $length / 2);
            return [
                new Stone((int) $parts[0]),
                new Stone((int) $parts[1])
            ];
        }
        return [new Stone($this->value * 2024)];
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getBlinked(): int
    {
        return $this->blinked;
    }
}