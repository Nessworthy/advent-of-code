<?php declare(strict_types=1);

namespace Nessworthy\AoC\Coordinates;

use Generator;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Grid\GridDirection;

class Point2DHelper {

    public static function bump(Point2D $point2D, GridDirection $gridDirection): Point2D {
        switch ($gridDirection) {
            case GridDirection::LEFT:
                return new Point2D($point2D->x() - 1, $point2D->y());
            case GridDirection::RIGHT:
                return new Point2D($point2D->x() + 1, $point2D->y());
            case GridDirection::UP:
                return new Point2D($point2D->x(), $point2D->y() - 1);
            case GridDirection::DOWN:
                 return new Point2D($point2D->x(), $point2D->y() + 1);
            case GridDirection::DIAGONAL_DOWN_LEFT:
                return new Point2D($point2D->x() - 1, $point2D->y() + 1);
            case GridDirection::DIAGONAL_DOWN_RIGHT:
                return new Point2D($point2D->x() + 1, $point2D->y() + 1);
            case GridDirection::DIAGONAL_UP_LEFT:
                return new Point2D($point2D->x() - 1, $point2D->y() - 1);
            case GridDirection::DIAGONAL_UP_RIGHT:
                return new Point2D($point2D->x() + 1, $point2D->y() - 1);
        }
        throw new \RuntimeException('Invalid GridDirection');
    }

    public static function getNeighbouringPoints(Point2D $point2D, $minX, $maxX, $minY, $maxY): Generator {
        $canGoLeft = $point2D->x() - 1 >= $minX;
        $canGoRight = $point2D->x() + 1 <= $maxX;
        $canGoUp = $point2D->y() - 1 >= $minY;
        $canGoDown = $point2D->y() + 1 <= $maxY;

        if ($canGoUp) {
            if ($canGoLeft) {
                yield GridDirection::DIAGONAL_UP_LEFT => new Point2D($point2D->x() - 1, $point2D->y() - 1);
            }

            yield GridDirection::UP =>new Point2D($point2D->x(), $point2D->y() - 1);

            if ($canGoRight) {
                yield GridDirection::DIAGONAL_UP_RIGHT =>new Point2D($point2D->x() + 1, $point2D->y() - 1);
            }
        }

        if ($canGoLeft) {
            yield GridDirection::LEFT =>new Point2D($point2D->x() - 1, $point2D->y());
        }

        if ($canGoRight) {
            yield GridDirection::RIGHT => new Point2D($point2D->x() + 1, $point2D->y());
        }

        if ($canGoDown) {
            if ($canGoLeft) {
                yield GridDirection::DIAGONAL_DOWN_LEFT =>new Point2D($point2D->x() - 1, $point2D->y() + 1);
            }

            yield GridDirection::DOWN => new Point2D($point2D->x(), $point2D->y() + 1);

            if ($canGoRight) {
                yield GridDirection::DIAGONAL_DOWN_RIGHT => new Point2D($point2D->x() + 1, $point2D->y() + 1);
            }
        }
    }
}
