<?php

if(!function_exists("fs")){

	function fs(string $dir = null){

		if(!is_null($dir))
			return new Strukt\Local\Fs(Strukt\Fs::ds($dir));

		return new Strukt\Fs();
	}

	function tail(string $filepath, int $lines = 20){

		return Strukt\Fs::tail($filepath, $lines);
	}
}