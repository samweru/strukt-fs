<?php

namespace Strukt;

class Phar{

	public static function adapt(string $path = ""){

		$phar_path = \Phar::running();

		$pwd = !empty($phar_path)?$phar_path:getcwd();

		return Fs::ds(trim(sprintf("%s/%s", $pwd, $path)));
	}

	/**
	 * @source \Psysh\Shell
     * Check if the currently running PsySH bin is a phar archive.
     */
    public static function isPhar(): bool
    {
        return \class_exists("\Phar") && \Phar::running() !== '' && \strpos(__FILE__, \Phar::running(true)) === 0;
    }
}