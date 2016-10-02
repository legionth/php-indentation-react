# legionth/indentation-react

Indenter to indent the lines of an incoming stream, on top of reactPHP

This project should show how awesome [streams](https://github.com/reactphp/stream) are and why they should be used. This project use a combination of writable and readable streams. Checkout the [Usage](#usage) for more information.

**Table of Contents**
* [Usage](#usage)
 * [Indenter](#indenter)
* [License](#license)

## Usage

### Indenter

The center of this project is the `Indenter` class. This class (obviously) indents the incomig stream into an outgoing stream. The `Indenter` is an `EventEmitter` and a `ReadableStreamInterface`. Because this class is a `ReadableStreamInterface` the indented data will be exposed on the same interface.

To use this data you have to pipe it into another stream, checkout the `examples` folder.

So what is the reason for this project? This project just shows how awesome the ReactPHP streams are. Streams can come in different sizes: bigger parts, smaller parts, etc. depending on your data source(Downloads, Files, Strings ...). 
In this project you can be sure a chunk is complete when the new line delimiter comes in, so the next line will be indented. So you can be sure the stream is always correctly indented.
 
You can find under `examples` how you can use this project.
If you need a file to be indented you can pipe the file into the example.

```
$ cat words.txt | php examples/indentInput.php
```
This command can be started on its own.

```
$ php examples/indentInput.php
```

The first example makes clear why this project should be used. You can indent a whole file with one little example. If you want, you can pipe a command output into this example to see how it works. Just try it.

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
