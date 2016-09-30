# legionth/indentation-react

Indenter to indent the lines of an incoming stream, on top of reactPHP

**Table of Contents**
* [Explanation](#explanation)
* [Usage](#usage)
 * [Indenter](#indenter)
* [License](#license)

## Explanation

This project is build on top of reactPHP.

Essentially for this project are the [streams](https://github.com/reactphp/stream) of ReactPHP. These streams are seperated into Writeable and Readable streams so we can receive the data from a writable stream and put them into an output stream.

## Usage

### Indenter

The `Indenter` class makes sure that every entered stream will be indented and will be written into an output stream. The `Indenter` is an `EventEmitter` and a `ReadableStreamInterface`.

```php
$input = new Stream(STDIN, $loop);

$stream = new Indenter($input);

$stream->on('data', function ($data) {
    var_dump($data);
});
```
The input of this stream will be indented and will be exposed on the same interface.

React streams can be seperated into small or bigger chunks depending on the incoming data. Because of this a new stream will be indented and only new lines with a new line delimiter will be indented too. So you can be sure that a running stream is not accidentally falsly indetented independently of how big your stream is.

You can find under `examples` how you can use this project.
If you need a file to be indented you can pipe the file into the example.

```
$ cat words.txt | php examples/indentInput.php
```
This command can be started on its own.

```
$ php examples/indentInput.php
```

Note: The intention of this project may be unclear if you use the example on its own. Because you have a input stream and to send the typed data to this stream you have to hit the enter button, which is not a linebreak. Only your first entered stream will be indented, the rest will be considered to be related to the first entered string.

To see the `Indenter` work you should pipe a file or a command input into the example.

## Install

The recommended way to install this library is [through Composer](https://getcomposer.org).
[New to Composer?](https://getcomposer.org/doc/00-intro.md)

This will install the latest supported version:

```bash
$ composer require legionth/indentation-react:^0.1
```

See also the [CHANGELOG](CHANGELOG.md) for details about version upgrades.

## License

MIT
