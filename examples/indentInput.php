<?php

use React\Stream\Stream;
use React\EventLoop\Factory;
use Legionth\React\Indentation\Indenter;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

// Create a input stream
$input = new Stream(STDIN, $loop);
$parser = new Indenter($input);

// Use a seperate output stream
$output = new Stream(STDOUT, $loop);
// The loop shouldn't wait for an output stream, so set this stream on pause
$output->pause();

$parser->pipe($output);

$loop->run();
