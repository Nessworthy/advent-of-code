<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\Bingo;

class BingoBoard
{
    private array $gridOfNumbers;
    private int $size = 0;
    private array $numberList = [];

    private array $markedNumbers = [];

    public function __construct(array $gridOfNumbers)
    {
        $this->gridOfNumbers = $gridOfNumbers;
        if (isset($gridOfNumbers[0])) {
            $this->size = count($gridOfNumbers[0]);
        }

        foreach ($this->gridOfNumbers as $rowIndex => $row) {
            $this->numberList[$rowIndex] = $row;
            foreach ($row as $columnIndex => $column) {
                if (!isset($this->numberList[$this->size + $columnIndex])) {
                    $this->numberList[$this->size + $columnIndex] = [];
                }
                $this->numberList[$this->size + $columnIndex][$rowIndex] = $column;
            }
        }
    }

    public function markNumber(int $number): void {
        $this->markedNumbers[$number] = true;
    }

    public function hasBingo(): bool {
        $markedNumbers = array_keys($this->markedNumbers);
        foreach ($this->numberList as $numberSet) {
            if (count(array_intersect($numberSet, $markedNumbers)) === $this->size) {
                return true;
            }
        }
        return false;
    }

    public function getScore(): int {
        $markedNumbers = array_keys($this->markedNumbers);
        return array_sum(array_diff(array_merge(...$this->gridOfNumbers), $markedNumbers));
    }
}
