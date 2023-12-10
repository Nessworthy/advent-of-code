<?php declare(strict_types=1);

namespace Nessworthy\AoC\Coordinates;

use Generator;

class Point2DHelper {

    public static function getNeighbouringPoints(Point2D $point2D, $minX, $maxX, $minY, $maxY): Generator {
        $canGoLeft = $point2D->x() - 1 >= $minX;
        $canGoRight = $point2D->x() + 1 <= $maxX;
        $canGoUp = $point2D->y() - 1 >= $minY;
        $canGoDown = $point2D->y() + 1 <= $maxY;

        if ($canGoUp) {
            if ($canGoLeft) {
                yield new Point2D($point2D->x() - 1, $point2D->y() - 1);
            }

            yield new Point2D($point2D->x(), $point2D->y() - 1);

            if ($canGoRight) {
                yield new Point2D($point2D->x() + 1, $point2D->y() - 1);
            }
        }

        if ($canGoLeft) {
            yield new Point2D($point2D->x() - 1, $point2D->y());
        }

        if ($canGoRight) {
            yield new Point2D($point2D->x() + 1, $point2D->y());
        }

        if ($canGoDown) {
            if ($canGoLeft) {
                yield new Point2D($point2D->x() - 1, $point2D->y() + 1);
            }

            yield new Point2D($point2D->x(), $point2D->y() + 1);

            if ($canGoRight) {
                yield new Point2D($point2D->x() + 1, $point2D->y() + 1);
            }
        }
    }
}
