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

	function ds(string $path){

		return Strukt\Fs::ds(sprintf("%s/", trim($path, "/")));
	}

	function path_exists(string $path){

		return fs()->isDir($path) || fs()->isPath($path);
	}
}