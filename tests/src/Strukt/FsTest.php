<?php

use Strukt\Fs;

class FsTest extends PHPUnit_Framework_TestCase{

	public function testMkdir(){

		if(!Fs::isPath("tmp"))
			$this->assertTrue(Fs::mkdir("tmp"));
	}

	public function testTouchWrite(){

		if(Fs::isWritable("tmp")){

			if(!Fs::isFile("tmp/test.log"))
				$this->assertTrue(Fs::touchWrite("tmp/test.log", "Hello World!"));
			elseif(!Fs::isWritable("tmp/test.log"))
				$this->assertTrue(Fs::overwrite("tmp/test.log", "Overwrite hello world!"));
			else
				$this->skip();
		}
		else
			$this->skip();
	}

	/**
	* @depends testTouchWrite
	*/
	public function testAppendWrite(){

		if(Fs::isWritable("tmp/test.log"))
			$this->assertTrue(is_numeric(Fs::appendWrite("tmp/test.log", "Append hello world!")));
		else
			$this->skip();
	}

	/**
	* @depends testTouchWrite
	*/
	public function testDumpContents(){

		if(Fs::isReadable("tmp/test.log"))
			$this->assertTrue(is_string(Fs::cat("tmp/test.log")));
		else
			$this->skip();
	}

	/**
	* @depends testTouchWrite
	*/
	public function testRename(){

		$this->assertTrue(Fs::rename("tmp/test.log", "tmp/test2.log"));
	}

	/**
	* @depends testRename
	*/
	public function testRemoveFile(){

		$this->assertTrue(Fs::rm("tmp/test2.log"));
	}

	/**
	* @depends testMkdir
	*/
	public function testRemoveDirectory(){

		$this->assertTrue(Fs::rmdir("tmp"));
	}
}