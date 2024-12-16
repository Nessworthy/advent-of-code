<?php declare(strict_types = 1);

namespace Nessworthy\AoC\Grid;

enum GridDirection {
    case LEFT;
    case RIGHT;
    case UP;
    case DOWN;
    case DIAGONAL_UP_LEFT;
    case DIAGONAL_UP_RIGHT;
    case DIAGONAL_DOWN_LEFT;
    case DIAGONAL_DOWN_RIGHT;
}
