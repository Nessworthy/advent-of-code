<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\HydrothermalVentRadar;

use Generator;
use JetBrains\PhpStorm\Pure;
use Nessworthy\AoC\Coordinates\Point2D;

class VentRange
{
    private Point2D $from;
    private Point2D $to;

    public function __construct(Point2D $from, Point2D $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function pointInRangeGenerator(): Generator
    {
        $fromX = $this->from->x();
        $fromY = $this->from->y();

        $toX = $this->to->x();
        $toY = $this->to->y();

        $currentX = $fromX;
        $currentY = $fromY;

        while ($currentX !== $toX || $currentY !== $toY) {
            yield new Point2D($currentX, $currentY);
            if ($currentX !== $toX) {
                $currentX += 1 * -($currentX <=> $toX);
            }
            if ($currentY !== $toY) {
                $currentY += 1 * -($currentY <=> $toY);
            }
        }
        yield new Point2D($toX, $toY);
    }

    #[Pure] public function isHorizontalOrVerticalLine(): bool
    {
        return $this->to->x() === $this->from->x() || $this->to->y() === $this->from->y();
    }
}
