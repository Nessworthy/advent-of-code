<?php declare(strict_types=1);

use Auryn\Injector;
use Bramus\Ansi\Ansi;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use Bramus\Ansi\Writers\StreamWriter;
use Nessworthy\AoC2020\Common\Input;
use Nessworthy\AoC2020\Common\Output;
use Nessworthy\AoC2020\Common\OutputWriterAdapter;

require_once __DIR__ . '/../vendor/autoload.php';

$solve = $argv[1] ?? null;

// Auryn - Bootstrap

$injector = new Injector();

$injector->share($injector); // #yolo

$injector->share(Output::class);
$injector->share(Input::class);

$matches = [];
preg_match('#^Day(?<day>\d+)Part(?<part>\w+)$#', $solve, $matches);

$injector->define(Input::class, [
    ':filePath' => __DIR__ . '/../test/input/' . $matches['day'] . '.txt'
]);

$className = sprintf('Day%dPart%s', (int) $matches['day'], strtoupper($matches['part']));

$solution = $injector->make('Nessworthy\AoC2020\Solutions\\' . $className);
$result = $injector->execute([$solution, 'execute']);

$output = trim(file_get_contents(__DIR__ . '/../test/output/' . $matches['day'] . strtolower($matches['part']) . '.txt'));

/** @var Output $writer */
$writer = new OutputWriterAdapter($injector->make(Output::class));

$ansi = new Ansi($writer);

$ansi->lf()->bold()->text('Test results for Day ' . $matches['day'] . ', part ' . strtoupper($matches['part']))->nostyle()->lf()->lf();

$ansi->text('Answer expected: ' . $output)->lf();

$ansi->text('   Answer given: ')
    ->color($output === (string) $result ? SGR::COLOR_FG_GREEN : SGR::COLOR_FG_RED)->text($result)
    ->nostyle()->lf();



