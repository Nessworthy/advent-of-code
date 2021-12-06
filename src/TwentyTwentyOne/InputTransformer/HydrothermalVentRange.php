<?php declare(strict_types=1);

namespace Nessworthy\AoC\TwentyTwentyOne\InputTransformer;

use Generator;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Coordinates\Point2D;
use Nessworthy\AoC\TwentyTwentyOne\HydrothermalVentRadar\VentRange;
use RuntimeException;

class HydrothermalVentRange {

    private const INPUT_FORMAT = '#^(?<startX>\d+),(?<startY>\d+)\s+->\s+(?<endX>\d+),(?<endY>\d+)$#';

    public function ventRangeGenerator(Input $input): Generator
    {
        foreach ($input->readLine() as $line) {
            $matches = [];
            if (!preg_match(self::INPUT_FORMAT, $line, $matches)) {
                throw new RuntimeException('Input did not match expected pattern ("' . $line . '")');
            }
            yield new VentRange(
                new Point2D(
                    (int) $matches['startX'],
                    (int) $matches['startY']
                ),
                new Point2D(
                    (int) $matches['endX'],
                    (int) $matches['endY']
                )
            );
        }
    }
}
