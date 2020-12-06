<?php declare(strict_types=1);

use Auryn\Injector;
use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Solutions\DayOnePartOne;
use Nessworthy\AoC2020\Solutions\DayOnePartTwo;
use Nessworthy\AoC2020\Solutions\DayTwoPartOne;
use Nessworthy\AoC2020\Solutions\DayTwoPartTwo;

require_once __DIR__ . '/../vendor/autoload.php';

$solve = $argv[1] ?? null;

// Auryn - Bootstrap

$injector = new Injector();

$injector->share($injector); // #yolo

$injector->define(Input::class, [
    ':filePath' => match($solve) {
        '1a', '1b' => __DIR__ . '/../input/1a.txt',
        '2a', '2b' => __DIR__ . '/../input/2a.txt',
        default => throw new RuntimeException('Expected valid solution, none given.')
    }
]);

$solution = $injector->make(match($solve) {
    '1a' => DayOnePartOne::class,
    '1b' => DayOnePartTwo::class,
    '2a' => DayTwoPartOne::class,
    '2b' => DayTwoPartTwo::class,
    default => throw new Exception('No solution defined.')
});
$injector->execute([$solution, 'execute']);

