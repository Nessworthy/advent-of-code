<?php declare(strict_types=1);

use Auryn\Injector;
use Nessworthy\AoC2020\Common\Input;
require_once __DIR__ . '/../vendor/autoload.php';

$solve = $argv[1] ?? null;

// Auryn - Bootstrap

$injector = new Injector();

$injector->share($injector); // #yolo

$injector->define(Input::class, [
    ':filePath' => __DIR__ . '/../input/' . $solve[0] . 'a.txt'
]);

$className = sprintf('Day%dPart%s', (int) $solve[0], strtoupper($solve[1]));

$solution = $injector->make('Nessworthy\AoC2020\Solutions\\' . $className);
$injector->execute([$solution, 'execute']);

