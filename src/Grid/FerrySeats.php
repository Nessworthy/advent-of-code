<?php

namespace Nessworthy\AoC2020\Grid;

use Generator;
use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;

class FerrySeats
{
    protected array $empty = [];
    protected array $filled = [];
    protected int $width;
    protected int $height;
    private int $pass = 0;

    protected const SEAT_FILLED = '#';
    protected const SEAT_EMPTY = 'L';
    protected const SEAT_NONEXISTENT = '.';

    /**
     * @var Output
     */
    private Output $output;
    protected int $humanTolerance = 4;

    public function process(Input $input, Output $output): void
    {
        $first = true;
        $width = 0;
        $lastYPos = 0;
        $this->empty = [];
        $this->filled = [];
        $this->pass = 0;
        $this->output = $output;
        foreach ($input->readLine() as $yPos => $line) {
            if ($first) {
                $first = false;
                $width = strlen($line);
                $this->width = $width;
            }
            $yBuffer = $yPos * $width;
            foreach (str_split($line) as $xPos => $char) {
                $pos = $yBuffer + $xPos;
                if ($char === self::SEAT_FILLED) {
                    $this->filled[$pos] = true;
                } elseif ($char === self::SEAT_EMPTY) {
                    $this->empty[$pos] = true;
                }
            }
            $lastYPos = $yPos;
        }
        $this->height = $lastYPos + 1;

        $output->writeLine('Seated: ' . count($this->filled));
        $output->writeLine('Empty: ' . count($this->empty));
        $this->logView();
    }

    public function performPass(): int
    {
        ++$this->pass;
        $filled = $this->filled;
        $empty = $this->empty;

        // If a seat is empty, and there's a no occupied seats adjacent to it, the seat becomes occupied.

        foreach ($this->empty as $position => $unused) {
            foreach ($this->getAdjacentPositions($position) as $adjacentPosition) {
                if (isset($this->filled[$adjacentPosition])) {
                    continue 2;
                }
            }
            unset($empty[$position]);
            $filled[$position] = true;
        }

        // If a seat is occupied and four or more adjacent seats are also occupied, the seat becomes empty.
        foreach ($this->filled as $position => $unused) {
            $occupied = 0;
            foreach ($this->getAdjacentPositions($position) as $adjacentPosition) {
                if (isset($this->filled[$adjacentPosition])) {
                    ++$occupied;

                    if ($occupied >= $this->humanTolerance) {
                        unset($filled[$position]);
                        $empty[$position] = true;
                        continue 2;
                    }
                }
            }
        }

        ksort($filled);
        ksort($empty);

        $this->filled = $filled;
        $this->empty = $empty;

        $this->output->writeLine('Pass ' . $this->pass);
        $this->output->writeLine('Seated: ' . count($this->filled));
        $this->output->writeLine('Empty: ' . count($this->empty));
        $this->logView();
        return count($this->filled);
    }

    public function performPassUntilNobodyMoves(): int
    {
        $currentDigest = md5(json_encode($this->filled) . json_encode($this->empty));
        $lastDigest = null;
        $result = 0;

        while ($lastDigest !== $currentDigest) {
            $lastDigest = $currentDigest;
            $result = $this->performPass();
            $currentDigest = md5(json_encode($this->filled) . json_encode($this->empty));
        }

        return $result;
    }

    protected function getAdjacentPositions(int $index): Generator {

        $yPos = $index === 0 ? 0 : (int) floor($index / $this->width);
        $xPos = $index % $this->width;

        $againstRight = $xPos === $this->width - 1;
        $againstLeft = $xPos === 0;
        $againstTop = $yPos === 0;
        $againstBottom = $yPos === $this->height - 1;

        if (!$againstLeft) {
            yield ($yPos * $this->width) + ($xPos - 1);
        }
        if (!$againstRight) {
            yield ($yPos * $this->width) + ($xPos + 1);
        }
        if (!$againstTop) {
            yield (($yPos - 1) * $this->width) + $xPos;
        }
        if (!$againstBottom) {
            yield (($yPos + 1) * $this->width) + $xPos;
        }
        if (!$againstBottom && !$againstLeft) {
            yield (($yPos + 1) * $this->width) + ($xPos - 1);
        }
        if (!$againstBottom && !$againstRight) {
            yield (($yPos + 1) * $this->width) + ($xPos + 1);
        }
        if (!$againstTop && !$againstLeft) {
            yield (($yPos - 1) * $this->width) + ($xPos - 1);
        }
        if (!$againstTop && !$againstRight) {
            yield (($yPos - 1) * $this->width) + ($xPos + 1);
        }
    }

    private function logView()
    {
        $this->output->write("\n");
        for ($i = 0; $i < ($this->width * $this->height); ++$i) {
            if (isset($this->empty[$i])) {
                $this->output->write(self::SEAT_EMPTY);
            } elseif (isset($this->filled[$i])) {
                $this->output->write(self::SEAT_FILLED);
            } else {
                $this->output->write(self::SEAT_NONEXISTENT);
            }
            if ($i % $this->width === $this->width - 1) {
                $this->output->write("\n");
            }
        }
        $this->output->write("\n");
        $this->output->write("\n");
    }


}
