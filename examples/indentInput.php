<?php

use React\Stream\Stream;
use React\EventLoop\Factory;
use Legionth\React\Indentation\Indenter;
use CLIOpts\CLIOpts;
require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$values = CLIOpts::run('
{self} [options]
-t, --tab add tabulator as indentation
-s, --spaces <number> (required)');

$indentation = '    ';
if (isset($values['tab'])) {
	$indentation = "\t";
}
if (isset($values['spaces'])) {
	$indentation = '';
	for ($i = 0; $i < $values['spaces']; $i++ ) {
		$indentation .= ' ';
	}
}

// Create a input stream
$input = new Stream(STDIN, $loop);
$parser = new Indenter($input, $indentation);
// Use a seperate output stream
$output = new Stream(STDOUT, $loop);
// The loop shouldn't wait for an output stream, so set this stream on pause
$output->pause();
$parser->emit('data', array('test'));

$parser->pipe($output);

$loop->run();
