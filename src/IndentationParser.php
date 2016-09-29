<?php

namespace Legionth\React\Indentation;

use Evenement\EventEmitter;
use React\Stream\ReadableStreamInterface;
use React\Stream\WritableStreamInterface;
use React\Stream\Util;

/**
 *  This class indents the input by 4 spaces and writes it into a stream
 */
class IndentationParser extends EventEmitter implements ReadableStreamInterface
{
    private $closed = false;
    private $started = true;
    
    
    public function __construct(ReadableStreamInterface $input)
    {
        $this->input = $input;
    
        $this->input->on('data', array($this, 'handleData'));
        $this->input->on('end', array($this, 'handleEnd'));
        $this->input->on('error', array($this, 'handleError'));
        $this->input->on('close', array($this, 'close'));
    }
    
    /**
     * Writes the inputted data into a readable stream
     * 
     * @param string $data - string entered by the input stream
     */
    public function handleData($data)
    {
        if ($this->started) {
            $data = '    ' . $data;
            $this->started = false;
        }
        
        $data = str_replace(PHP_EOL, PHP_EOL . '    ', $data);
        $this->emit('data', array($data));
        
    }
    
    /** @internal */
    public function handleEnd()
    {
        if (!$this->closed) {
            $this->emit('end');
            $this->close();
        }
    }
    
    /** @internal */
    public function handleError(\Exception $e)
    {
        $this->emit('error', array($e));
        $this->close();
    }
    
    public function isReadable()
    {
        return !$this->closed && $this->input->isReadable();
    }
    
    public function pause()
    {
        $this->input->pause();
    }
    
    public function resume()
    {
        $this->input->resume();
    }

    public function pipe(WritableStreamInterface $dest, array $options = array())
    {
        Util::pipe($this, $dest, $options);
    
        return $dest;
    }

    public function close()
    {
        if ($this->closed) {
            return;
        }
    
        $this->closed = true;
        $this->started = false;
    
        $this->input->close();
    
        $this->emit('close');
        $this->removeAllListeners();
    }
}
