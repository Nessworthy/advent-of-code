<?php declare(strict_types=1);

use Auryn\Injector;
use Nessworthy\AoC2020\Common\Input;
require_once __DIR__ . '/../vendor/autoload.php';

$solve = $argv[1] ?? null;

// Auryn - Bootstrap

$injector = new Injector();

$injector->share($injector); // #yolo

$matches = [];
preg_match('#^(?<day>\d+)(?<part>\w+)$#', $solve, $matches);

$injector->define(Input::class, [
    ':filePath' => __DIR__ . '/../input/' . $matches['day'] . 'a.txt'
]);

$className = sprintf('Day%dPart%s', (int) $matches['day'], strtoupper($matches['part']));

$solution = $injector->make('Nessworthy\AoC2020\Solutions\\' . $className);
$result = $injector->execute([$solution, 'execute']);
echo 'Answer given: ' . "\n" . '(' . gettype($result) . ') ' . $result;

