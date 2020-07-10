<?php 

namespace Strukt;

/**
* File System Class
*
* @author Moderator <pitsolu@gmail.com>
*/
class Fs{

	/**
	* Check if dir exists
	*
	* @param string $dir
	*
	* @return boolean
	*/
	public static function isDir($dir){

		return is_dir($dir);
	}

	/**
	* Check if file exists
	*
	* @param string $file
	*
	* @return boolean
	*/
	public static function isFile($file){

		clearstatcache();
		
		return is_file($file);
	}

	/**
	* Check if path exists
	*
	* @param string $path
	*
	* @return boolean
	*/
	public static function isPath($path){

		clearstatcache();

    	return file_exists($path);
  	}

  	/**
	* Dump file contents
	*
	* @param string $file
	*
	* @return boolean
	*/
	public static function cat($file){

		if(self::isFile($file))
			return @file_get_contents($file);

		return false;
	}

	/**
	* Create file
	*
	* @param string $file
	*
	* @return boolean
	*/
	public static function touch($file){

		if(self::isFile($file))
			return false;
	
		return touch($file);
	}

	/**
	* Create and write to file
	*
	* @param string $file 
	* @param string $contents
	*
	* @return boolean
	*/
	public static function touchWrite($file, $contents){

		if(self::touch($file))
			if(self::overwrite($file, $contents))
				return true;

		return false;
	}

	/**
	* Rename file
	*
	* @param string $from 
	* @param string $to
	*
	* @return boolean
	*/
	public static function rename($from, $to){

		if($from == $to)
			return false;

		$toFileExists = false;
		if(self::isFile($to))
			$toFileExists = true;

		$fromFileExists = false;
		if(self::isFile($from))
			$fromFileExists = true;
		
		if($toFileExists && $fromFileExists)
			if(rename($to, sprintf("%s_%s_%s.bak", $to, date("Y-m-d_H-i-s"), rand())))
				return rename($from, $to);
		
		if($fromFileExists && !$toFileExists)
			return rename($from, $to);

		return false;
	}

	/**
	* Overwrite contents of file
	*
	* @param string $file 
	* @param string $contents
	*
	* @return boolean
	*/
	public static function overwrite($file, $contents, $noLockEx = true){

		if(!self::isFile($file))
			return false;

		if($noLockEx)
			return file_put_contents($file, $contents);

		return file_put_contents($file, $contents, LOCK_EX);
	}

	/**
	* Append contents to file
	*
	* @param string $file 
	* @param string $contents
	*
	* @return boolean
	*/
	public static function appendWrite($file, $contents, $noLockEx = true){

		if(!self::isFile($file))
			return false;

		if($noLockEx)
			return file_put_contents($file, $contents, FILE_APPEND);

		return file_put_contents($file, $contents, FILE_APPEND | LOCK_EX);
	}

	/**
	* Delete file
	*
	* @param string $file 
	*
	* @return boolean
	*/
	public static function rm($file){

		if(self::isFile($file))
			return unlink($file);

		return false;
	}

	/**
	* Recursively remove directory and sub resources
	*
	* @param string $dir
	*
	* @return boolean 
	*/
	public static function rmdir($dir) { 

		foreach(glob($dir . '/*') as $file){

	    	if(is_dir($file)) 
	      		self::rmdir($file); 

	    	if(is_file($file)) 
	      		unlink($file);
	    }

	  	return @rmdir($dir);
	}

	/**
	* Recursively make directory
	*
	* @param string $dir 
	*
	* @return boolean
	*/
	public static function mkdir($dir, $mode = 0755, $recursive = true){

		return @mkdir($dir, $mode, $recursive);
	}

	/**
	* Check if file or directory is writeable
	*
	* @param string $file 
	*
	* @return boolean
	*/
	public static function isWritable($file){

		if(self::isPath($file))
			return is_writable($file);

		return false;
	}

	/**
	* Check if file or directory is readable
	*
	* @param string $file 
	*
	* @return boolean
	*/
	public static function isReadable($file){

		if(self::isFile($file))
			return is_readable($file);

		return false;
	}

	/**
	 * Copy a file or recursively copy a directories contents
	 *
	 * @param string $source The path to the source file/directory
	 * @param string $dest The path to the destination directory
	 */
	public static function copyRecur($source, $dest){

	    if (is_dir($source)){

	        $iterator = new \RecursiveIteratorIterator(

	            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
	            \RecursiveIteratorIterator::SELF_FIRST
	        );

	        foreach ($iterator as $file)
	            if ($file->isDir())
	                mkdir($dest.DIRECTORY_SEPARATOR.$iterator->getSubPathName());
	            else
	                copy($file, $dest.DIRECTORY_SEPARATOR.$iterator->getSubPathName());
	    }
	    else
	        copy($source, $dest);
	}

	/**
	 * Alias for Strukt\Fs::copyRecur
	 *
	 * @param string $source The path to the source file/directory
	 * @param string $dest The path to the destination directory
	 */
	public static function cpr($source, $dest){

		self::copyRecur($source, $dest);
	}

	/**
	* List files recursively
	*
	* @param string $path The path to directory
	*/
	public static function listFilesRecur($path){

	    $rItrItr = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

		$files = []; 

		foreach ($rItrItr as $file) {

		    if ($file->isDir())
		        continue;

		    $files[] = $file->getPathname(); 
		}

		return $files;
	}

	/**
	* Alias Strukt/Fs::listFilesRecur
	*
	* @param string $path The path to directory
	*/
	public static function lsr($path){

		return self::listFilesRecur($path);
	}

	/**
	* Which OS
	*
	* @return string
	*/
	public static function isWindows(){

		return strtoupper(substr(PHP_OS, 0, 3)) == "WIN";
	}
}