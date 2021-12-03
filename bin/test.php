<?php declare(strict_types=1);

use Auryn\Injector;
use Bramus\Ansi\Ansi;
use Bramus\Ansi\ControlSequences\EscapeSequences\Enums\SGR;
use Nessworthy\AoC\Common\Input;
use Nessworthy\AoC\Common\Output;
use Nessworthy\AoC\Common\OutputWriterAdapter;

require_once __DIR__ . '/../vendor/autoload.php';

$solve = $argv[1] ?? null;

// Auryn - Bootstrap

$injector = new Injector();

$injector->share($injector); // #yolo

$injector->share(Output::class);
$injector->share(Input::class);

$matches = [];
preg_match('#^Year(?<year>.+?)Day(?<day>\d+)Part(?<part>\w+)$#', $solve, $matches);

$yearNumeric = array_search($matches['year'], YEAR_MAP, true);

$inputFilePath = __DIR__ . '/../test/input/' . $yearNumeric . '/' . $matches['day'] . '.txt';
$outputFilePath = __DIR__ . '/../test/output/' . $yearNumeric . '/' . $matches['day'] . strtolower($matches['part']) . '.txt';

if (!file_exists($inputFilePath)) {
    /** @var Output $writer */
    $writer = new OutputWriterAdapter($injector->make(Output::class));
    $ansi = new Ansi($writer);
    $ansi->text('Skipping tests (no input file found)');
    exit(0);
}

if (!file_exists($outputFilePath)) {
    /** @var Output $writer */
    $writer = new OutputWriterAdapter($injector->make(Output::class));
    $ansi = new Ansi($writer);
    $ansi->text('Skipping tests (no output file found)');
    exit(0);
}

$injector->define(Input::class, [
    ':filePath' => $inputFilePath
]);

$className = sprintf('Day%sPart%s', $matches['day'], strtoupper($matches['part']));

$solution = $injector->make(sprintf('Nessworthy\AoC\Solutions\%s\%s', $matches['year'], $className));

$start = microtime(true);

$result = $injector->execute([$solution, 'solve']);

$end = microtime(true);
$taken = $end - $start;

$minutes = floor(floor($taken) / 60);
$seconds = floor($taken) - ($minutes * 60);
$milliseconds = floor(($taken - $seconds) * 1000);

$timeStr = '';
$color = SGR::COLOR_FG_WHITE;

if ($minutes) {
    $timeStr = sprintf('%dm %ds', $minutes, $seconds);
    $color = SGR::COLOR_FG_RED;
} elseif ($seconds) {
    $timeStr = sprintf('%d.%ds', $seconds, $milliseconds);
    $color = SGR::COLOR_FG_YELLOW;
} elseif ($milliseconds) {
    $timeStr = sprintf('%dms', $milliseconds);
    $color = SGR::COLOR_FG_GREEN;
} else {
    $color = SGR::COLOR_FG_CYAN;
    $timeStr = sprintf('%dµs', floor(($taken * 1000 * 1000) - floor($taken * 1000) * 1000));
}

$output = trim(file_get_contents($outputFilePath));

/** @var Output $writer */
$writer = new OutputWriterAdapter($injector->make(Output::class));

$ansi = new Ansi($writer);

$ansi
    ->lf()
    ->bold()
    ->text('Test results for ')
    ->color(SGR::COLOR_FG_YELLOW)
    ->text('day ' . $matches['day'] . ', part ' . strtoupper($matches['part']))->nostyle()->text(':')->lf()->lf();

$ansi->text('Answer expected: ' . $output)->lf();

$ansi->text('   Answer given: ')
    ->color($output === (string) $result ? SGR::COLOR_FG_GREEN : SGR::COLOR_FG_RED)->text($result)
    ->nostyle()->lf()->lf();

$ansi->text('     Time taken: ')->color($color)->text($timeStr)->lf();



