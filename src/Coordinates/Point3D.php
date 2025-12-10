<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Coordinates;

class Point3D extends Point2D {
    private int $z;

    public function __construct(int $x, int $y, int $z)
    {
        parent::__construct($x, $y);
        $this->z = $z;
    }

    public function z(): int {
        return $this->z;
    }

    public function __toString(): string
    {
        return parent::__toString() . ',' . $this->z;
    }

    public function getEuclideanDistanceTo(Point3D $point3D): int|float {

        return sqrt(
            ($this->x() - $point3D->x()) ** 2 +
            ($this->y() - $point3D->y()) ** 2 +
            ($this->z() - $point3D->z()) ** 2
        );

    }
}