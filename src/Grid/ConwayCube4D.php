<?php

namespace Nessworthy\AoC2020\Grid;

use Generator;

class ConwayCube4D
{
    /**
     * Just some notes..
     *
     * Difference here is the fourth dimension, which
     */

    private array $grid = [];

    public function setActive(int $x, int $y, int $z, int $w): void {

        if ($z < 0 || $w < 0) {
            return;
        }

        if (!isset($this->grid[$w])) {
            $this->grid[$w] = [];
        }

        if (!isset($this->grid[$w][$z])) {
            $this->grid[$w][$z] = [];
        }

        if (!isset($this->grid[$w][$z][$y])) {
            $this->grid[$w][$z][$y] = [];
        }

        if (!isset($this->grid[$w][$z][$y][$x])) {
            $this->grid[$w][$z][$y][$x] = true;
        }
    }

    public function setInactive(int $x, int $y, int $z, int $w): void {

        if ($z < 0 || $w < 0) {
            return;
        }

        if (isset($this->grid[$w][$z][$y][$x])) {
            unset($this->grid[$w][$z][$y][$x]);
        }

    }

    public function hasTwoOrThreeActiveNeighbours(int $x, int $y, int $z, int $w): bool {
        $active = 0;
        foreach ($this->getNeighbouringPoints($x, $y, $z, $w) as $neighbouringPoint) {
            if ($this->isActive(...$neighbouringPoint)) {
                ++$active;
            }
        }
        return $active === 2 || $active === 3;
    }


    public function hasThreeActiveNeighbours(int $x, int $y, int $z, int $w): bool
    {
        $active = 0;
        foreach ($this->getNeighbouringPoints($x, $y, $z, $w) as $neighbouringPoint) {
            if ($this->isActive(...$neighbouringPoint)) {
                ++$active;
            }
        }
        return $active === 3;
    }

    private function getNeighbouringPoints(int $x, int $y, int $z, int $w): Generator
    {
        for ($cw = $w - 1; $cw <= $w + 1; ++$cw) {
            for ($cz = $z - 1; $cz <= $z + 1; ++$cz) {
                for ($cy = $y - 1; $cy <= $y + 1; ++$cy) {
                    for ($cx = $x - 1; $cx <= $x + 1; ++$cx) {
                        // If we need to optimize this later, then we can wash that pig then.
                        if ($cx === $x && $cy === $y && $cz === $z && $cw === $w) {
                            continue;
                        }
                        yield [$cx, $cy, $cz, $cw];
                    }
                }
            }
        }
    }

    private function isActive(int $x, int $y, int $z, int $w): bool
    {
        return isset($this->grid[abs($w)][abs($z)][$y][$x]);
    }

    public function getNumberOfActivePoints(): int
    {
        $total = 0;
        foreach ($this->grid as $w => $cube) {
            $cubeAmount = 0;
            foreach ($cube as $z => $square) {
                $amount = array_sum(array_map('count', $square));
                if ($z > 0) {
                    $amount *= 2;
                }
                $cubeAmount += $amount;
            }
            if ($w > 0) {
                $cubeAmount *= 2;
            }
            $total += $cubeAmount;
        }
        return $total;
    }

    public function getActivePoints(): Generator
    {
        foreach ($this->grid as $w => $cube) {
            foreach ($cube as $z => $square) {
                foreach ($square as $y => $col) {
                    foreach ($col as $x => $unused) {
                        yield [$x, $y, $z, $w];
                    }
                }
            }
        }
    }

    public function getInactivePoints(): Generator
    {
        // Tough one! We only care about inactive points neighbouring active ones, so let's only get those.
        $alreadyDone = [];
        foreach ($this->getActivePoints() as $activePoint) {
            foreach ($this->getNeighbouringPoints(...$activePoint) as $neighbouringPoint) {
                if ($this->isActive(...$neighbouringPoint)) {
                    continue;
                }
                if (in_array($neighbouringPoint, $alreadyDone, true)) {
                    continue;
                }
                $alreadyDone[] = $neighbouringPoint;
                yield $neighbouringPoint;
            }
        }
    }
}
