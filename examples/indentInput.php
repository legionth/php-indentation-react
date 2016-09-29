<?php

use React\Stream\Stream;
use React\EventLoop\Factory;
use Legionth\React\Indentation\IndentationParser;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

// Create a input stream on CLI
$input = new Stream(STDIN, $loop);
$parser = new IndentationParser($input);

// Use a seperate output stream to show on CLI
$output = new Stream(STDOUT, $loop);
// The loop shouldn't wait for an output stream, so set this stream on pause
$output->pause();

$parser->pipe($output);

$loop->run();
