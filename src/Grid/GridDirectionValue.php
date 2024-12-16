<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Grid;

class GridDirectionValue {
    public static function getValue(GridDirection $gridDirection) {
        switch ($gridDirection) {
            case GridDirection::LEFT:
                return 'LEFT';
            case GridDirection::RIGHT:
                return 'RIGHT';
            case GridDirection::UP:
                return 'UP';
            case GridDirection::DOWN:
                return 'DOWN';
            case GridDirection::DIAGONAL_UP_LEFT:
                return 'DIAGONAL_UP_LEFT';
            case GridDirection::DIAGONAL_UP_RIGHT:
                return 'DIAGONAL_UP_RIGHT';
            case GridDirection::DIAGONAL_DOWN_LEFT:
                return 'DIAGONAL_DOWN_LEFT';
            case GridDirection::DIAGONAL_DOWN_RIGHT:
                return 'DIAGONAL_DOWN_RIGHT';
        }
        throw new \RuntimeException('Unknown direction');
    }

}
