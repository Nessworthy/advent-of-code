<?php declare(strict_types=1);

namespace Nessworthy\AoC\Coordinates;

class Point2D
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function x(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function y(): int
    {
        return $this->y;
    }

    public function __toString(): string
    {
        return $this->x . ',' . $this->y;
    }

    public function is(Point2d $point2D): bool
    {
        return $this->x === $point2D->x() && $this->y === $point2D->y();
    }

    public function getAreaBetween(Point2D $point): int {
        return (1 + max($point->x(), $this->x) - min($point->x(), $this->x))
            * (1 + max($point->y(), $this->y) - min($point->y(), $this->y));
    }
}
