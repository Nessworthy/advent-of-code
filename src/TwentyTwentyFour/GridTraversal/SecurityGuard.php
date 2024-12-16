<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyFour\GridTraversal;

use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Coordinates\Point2DHelper;
use Nessworthy\AoC\Grid\Grid;
use Nessworthy\AoC\Grid\GridDirection;
use Nessworthy\AoC\Queue\RepeatingQueueGenerator;

class SecurityGuard {

    private RepeatingQueueGenerator $repeatingQueueGenerator;

    public function __construct(RepeatingQueueGenerator $repeatingQueueGenerator)
    {
        $this->repeatingQueueGenerator = $repeatingQueueGenerator;
    }

    private array $directions = [GridDirection::UP, GridDirection::RIGHT, GridDirection::DOWN, GridDirection::LEFT];

    public function traverse(Grid $grid, Point2D $start): \Generator {

        $current = $start;
        $directionQueue = $this->repeatingQueueGenerator->generate($this->directions);
        $direction = $directionQueue->current();

        while (true) {
            yield $current => $direction;
            $next = false;
            for ($looked = 0, $lookedLimit = count($this->directions); $looked < $lookedLimit; $looked ++) {
                $next = Point2DHelper::bump($current, $direction);
                $result = $grid->isPointInGrid($next) ? $grid->getByPoint($next) : false;
                if (!$result) {
                    // We've just tried to move off of the map.
                    return null;
                }
                if ($result !== '#') {
                    // Next step forward is open.
                    break;
                }

                // Next step forward is a wall, rotate again.
                $direction = $this->nextDirection($directionQueue);

                // Clear next position in case that was last rotation.
                $next = false;
            }
            if (!$next) {
                // Somehow we are trapped between 4 walls.
                throw new \RuntimeException('Trapped between 4 walls at ' . $current);
            }
            $current = $next;
        }

    }

    private function nextDirection(\Generator $generator) {
        $generator->next();
        return $generator->current();
    }

}
