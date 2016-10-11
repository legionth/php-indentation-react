<?php

use React\Stream\ReadableStream;
use Legionth\React\Indentation\Indenter;

class IndenterTest extends TestCase
{
    public function setUp()
    {
        $this->input = new ReadableStream();
        $this->parser = new Indenter($this->input);
    }
    
    public function testMethodIsCalled()
    {
        $this->parser->on('data', $this->expectCallableOnceWith('    hello'));
        $this->input->emit('data', array('hello'));
    }
    
    public function testMethodIsCalledTwoTimes()
    {
        $this->parser->on('data', $this->expectCallableConsecutive(2, array('    hello', 'world')));
        
        $this->input->emit('data', array('hello'));
        $this->input->emit('data', array('world'));
    }
    
    public function testWithLineBreak()
    {
        $this->parser->on('data', $this->expectCallableOnceWith('    hello' . PHP_EOL .'    world'));
        
        $this->input->emit('data', array('hello' . PHP_EOL . 'world'));
    }
    
    public function testHandleClose()
    {
        $this->parser->on('close', $this->expectCallableOnce());
    
        $this->input->close();
    
        $this->assertFalse($this->parser->isReadable());
    }
    
    public function testHandleError()
    {
        $this->parser->on('error', $this->expectCallableOnce());
        $this->parser->on('close', $this->expectCallableOnce());
    
        $this->input->emit('error', array(new \RuntimeException()));
    
        $this->assertFalse($this->parser->isReadable());
    }
    
    public function testPauseStream()
    {
        $input = $this->getMock('React\Stream\ReadableStreamInterface');
        $input->expects($this->once())->method('pause');
        
        $parser = new Indenter($input);
        $parser->pause();
    }
    
    public function testResumeStream()
    {
        $input = $this->getMock('React\Stream\ReadableStreamInterface');
        $input->expects($this->once())->method('pause');
        
        $parser = new Indenter($input);
        $parser->pause();
        $parser->resume();
    }
    
    public function testPipeStream()
    {
        $dest = $this->getMock('React\Stream\WritableStreamInterface');
        
        $ret = $this->parser->pipe($dest);
        
        $this->assertSame($dest, $ret);
    }
    
    public function testAnotherIndentionParameter()
    {
    	$indenter = new Indenter($this->input , '  ');
    	
    	$indenter->on('data', $this->expectCallableOnceWith('  hello'));
    	 
    	$this->input->emit('data', array('hello'));
    }
    
    private function expectCallableConsecutive($numberOfCalls, array $with)
    {
        $mock = $this->createCallableMock();
    
        for ($i = 0; $i < $numberOfCalls; $i++) {
            $mock
                ->expects($this->at($i))
                ->method('__invoke')
                ->with($this->equalTo($with[$i]));
        }
    
        return $mock;
    }
}
