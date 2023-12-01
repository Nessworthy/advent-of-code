<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyTwo\TreeGrid;

use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\Grid\Grid;

class TreeGrid {

    private Grid $grid;

    private const MAX_TREE_HEIGHT = 9;

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    public function getVisibleTreesFromPoint(Point2D $point): int {

        $grid = $this->grid;
        $treeHouseHeight = $grid->getByPoint($point);

        return 0;

    }

    public function getVisibleTrees(): int
    {

        $grid = $this->grid;

        $w = $grid->getWidth();
        $h = $grid->getHeight();

        $visibleTrees = [];

        for ($x = 0; $x < $w; ++$x) {
            $tallestTree = -1;
            foreach ($grid->getColumn($x) as $y => $tree) {
                if ($tree > $tallestTree) {
                    echo "$x,$y ($tree) can be seen from the outside. (down, col $x)\n";
                    $visibleTrees[] = $x . ',' . $y;
                    $tallestTree = $tree;

                    if ($tallestTree === self::MAX_TREE_HEIGHT) {
                        break;
                    }
                }
            }
            $tallestTree = -1;
            foreach (array_reverse($grid->getColumn($x), true) as $y => $tree) {
                if ($tree > $tallestTree) {
                    echo "$x,$y ($tree) can be seen from the outside. (up, col $x)\n";
                    $visibleTrees[] = $x . ',' . $y;
                    $tallestTree = $tree;

                    if ($tallestTree === self::MAX_TREE_HEIGHT) {
                        break;
                    }
                }
            }
        }

        for ($y = 0; $y < $h; ++$y) {
            $tallestTree = -1;
            foreach ($grid->getRow($y) as $x => $tree) {
                if ($tree > $tallestTree) {
                    echo "$x,$y ($tree) can be seen from the outside (right, row $y).\n";
                    $visibleTrees[] = $x . ',' . $y;
                    $tallestTree = $tree;

                    if ($tallestTree === self::MAX_TREE_HEIGHT) {
                        break;
                    }
                }
            }
            $tallestTree = -1;
            foreach (array_reverse($grid->getRow($y), true) as $x => $tree) {
                if ($tree > $tallestTree) {
                    echo "$x,$y ($tree) can be seen from the outside (left, row $y).\n";
                    $visibleTrees[] = $x . ',' . $y;
                    $tallestTree = $tree;

                    if ($tallestTree === self::MAX_TREE_HEIGHT) {
                        break;
                    }
                }
            }
        }

        return count(array_unique($visibleTrees));
    }

}
