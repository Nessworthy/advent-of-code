<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\Rucksack;

class Item {
    private const LOWERCASE_OFFSET = -96;
    private const UPPERCASE_OFFSET = -64 + 26;

    private string $item;

    public function __construct(string $item)
    {
        $this->item = $item;
    }

    public function __toString() {
        return $this->item;
    }

    private function isUppercase(): bool {
        return strtoupper($this->item) === $this->item;
    }

    public function getItem(): string {
        return (string) $this;
    }
    public function getValue(): int {
        $offset = $this->isUppercase() ? self::UPPERCASE_OFFSET : self::LOWERCASE_OFFSET;
        return ord($this->item) + $offset;
    }
}
