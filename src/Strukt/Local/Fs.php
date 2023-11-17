<?php 

namespace Strukt\Local;

use Strukt\Fs as CoreFs;

/**
* File System Class (Local)
*
* @author Moderator <pitsolu@gmail.com>
*/
class Fs{

	private $path;

	public function __construct(string $path){

		$phar = \Phar::running();
		$phar_path = sprintf("phar://%s", $phar);
		if(!empty($phar))
			$path = sprintf("%s/%s", rtrim($phar_path, "/"), trim($path, "/"));

		$this->path = CoreFs::ds($path);
	}

	protected function path($path){

		return CoreFs::ds(sprintf("%s/%s", $this->path, $path));
	}

	/**
	* Check if dir exists
	*
	* @param string $dir
	*
	* @return boolean
	*/
	public function isDir($dir){

		return CoreFs::isDir($this->path($dir));
	}

	/**
	* Check if file exists
	*
	* @param string $file
	*
	* @return boolean
	*/
	public function isFile($file){
		
		return CoreFs::isFile($this->path($file));
	}

	/**
	* Check if path exists
	*
	* @param string $path
	*
	* @return boolean
	*/
	public function isPath($path){

    	return CoreFs::isPath($this->path($path));
  	}

  	/**
	* Dump file contents
	*
	* @param string $file
	*
	* @return boolean
	*/
	public function cat($file){

		return CoreFs::cat($this->path($file));
	}

	/**
	* Create file
	*
	* @param string $file
	*
	* @return boolean
	*/
	public function touch($file){

		return CoreFs::touch($this->path($file));
	}

	/**
	* Create and write to file
	*
	* @param string $file 
	* @param string $contents
	*
	* @return boolean
	*/
	public function touchWrite($file, $contents){

		return CoreFs::touchWrite($this->path($file), $contents);
	}

	/**
	* Rename file
	*
	* @param string $from 
	* @param string $to
	*
	* @return boolean
	*/
	public function rename($from, $to){

		return CoreFs::rename($this->path($from), $this->path($to));
	}

	/**
	* Overwrite contents of file
	*
	* @param string $file 
	* @param string $contents
	*
	* @return boolean
	*/
	public function overwrite($file, $contents, $noLockEx = true){

		return CoreFs::overwrite($this->path($file), $contents, $noLockEx);
	}

	/**
	* Append contents to file
	*
	* @param string $file 
	* @param string $contents
	*
	* @return boolean
	*/
	public function appendWrite($file, $contents, $noLockEx = true){

		return CoreFs::appendWrite($this->path($file), $contents, $noLockEx);
	}

	/**
	* Delete file
	*
	* @param string $file 
	*
	* @return boolean
	*/
	public function rm($file){

		return CoreFs::rm($this->path($file));
	}

	/**
	* Recursively remove directory and sub resources
	*
	* @param string $dir
	*
	* @return boolean 
	*/
	public function rmdir($dir) { 

		return CoreFs::rmdir($this->path($dir));
	}

	/**
	* Recursively make directory
	*
	* @param string $dir 
	*
	* @return boolean
	*/
	public function mkdir($dir, $mode = 0755, $recursive = true){

		return CoreFs::mkdir($this->path($dir), $mode, $recursive);
	}

	/**
	* Check if file or directory is writeable
	*
	* @param string $file 
	*
	* @return boolean
	*/
	public function isWritable($file){

		return CoreFs::isWritable($this->path($file));
	}

	/**
	* Check if file or directory is readable
	*
	* @param string $file 
	*
	* @return boolean
	*/
	public function isReadable($file){

		return CoreFs::isReadable($this->path($file));
	}

	/**
	 * Copy a file or recursively copy a directories contents
	 *
	 * @param string $source The path to the source file/directory
	 * @param string $dest The path to the destination directory
	 */
	public function copyRecur($source, $dest){

	    CoreFs::copyRecur($this->path($source), $this->path($dest));
	}

	/**
	 * Alias for Strukt\Fs::copyRecur
	 *
	 * @param string $source The path to the source file/directory
	 * @param string $dest The path to the destination directory
	 */
	public function cpr($source, $dest){

		self::copyRecur($source, $dest);
	}

	/**
	* List files
	*
	* @param string $path The path to directory
	*/
	public function listFiles($path="."){

	    return CoreFs::listFiles($this->path($path));
	}

	/**
	* Alias of Strukt/Fs::listFiles
	*
	* @param string $path The path to directory
	*/
	public function ls($path="."){

		return self::listFiles($path);
	}

	/**
	* List files recursively
	*
	* @param string $path The path to directory
	*/
	public function listFilesRecur($path="."){

	    return CoreFs::listFilesRecur($this->path($path));
	}

	/**
	* Alias Strukt/Fs::listFilesRecur
	*
	* @param string $path The path to directory
	*/
	public function lsr($path="."){

		return self::listFilesRecur($path);
	}

	/**
	* Read last lines of file
	*
	* @return string
	*/
	public function tail(string $filepath, int $lines = 20){

		return CoreFs::tail($this->path($filepath), $lines);
	}

	/**
	* Zip a directory
	*
	* @return boolean
	*/
	public function zip($path, $zipfile = null){

		return CoreFs::zip($this->path($path), $zipfile);
	}

	/**
	* Unzip dir
	*
	* @return boolean
	*/
	public function unzip(string $zipfile, string $topath = "./"){

		return CoreFs::unzip($this->path($zipfile), $this->path($topath));
	}

	/**
	* List what is in a *.zip file
	* 
	* @return string
	*/
	public function lsz($zippath){

		return CoreFs::lsz($this->path($zippath));
	}
}