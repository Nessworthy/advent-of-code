<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\Visualizer;

use Nessworthy\AoC\Common\Output;

class HydrothermalVentMap {

    private const SPACE_EMPTY = '.';

    /**
     * @param array $points
     * @param Output $output
     */
    public function visualize(array $points, Output $output): void {

        $sizeX = 0;
        $sizeY = 0;

        $outputArr = [];

        foreach ($points as $pointKey => $numberOverlay) {
            [$x, $y] = array_map('toInt', explode(',', $pointKey));
            $sizeX = max($sizeX, $x + 1);
            $sizeY = max($sizeY, $y + 1);

            if (!isset($outputArr[$y])) {
                $outputArr[$y] = '';
            }

            if (strlen($outputArr[$y]) >= $x + 1) {
                $outputArr[$y][$x] = $numberOverlay;
            } else {
                $outputArr[$y] = str_pad(
                    $outputArr[$y],
                    $x,
                    self::SPACE_EMPTY,
                    STR_PAD_RIGHT
                ) . $numberOverlay;
            }
        }

        for ($row = 0; $row < $sizeY; ++$row) {
            if (!isset($outputArr[$row])) {
                $outputArr[$row] = str_repeat(self::SPACE_EMPTY, $sizeX);
            }
        }

        ksort($outputArr);

        $outputArr = array_map(
            static function($str) use ($sizeX) {
                return str_pad($str, $sizeX, self::SPACE_EMPTY, STR_PAD_RIGHT);
            },
            $outputArr
        );

        array_map(
            [$output, 'writeLine'],
            $outputArr
        );
    }
}
