<?php

/**
* 
*/

namespace Terminate\Autoload;
class ClassLoader
{
	public static $vendorDir;
	public static $baseDir;
	public static $Controller = "/routes/Controller.php";
	public static $Auth = "/routes/Auth.php";
	public static $App = "/routes/App.php";
	public static $Database = "/routes/Database.php";
	public static $Vendor = "/vendor/autoload.php";
	public function __construct()
	{
		static::$vendorDir = (dirname(dirname(__FILE__)));
		static::$baseDir = dirname(static::$vendorDir);
	}

	public function getFile($class=false)
	{
		if (!file_exists($class)) {
			echo E_USER_ERROR;
		}
		require $class;
	}

	public function start()
	{
		$this->getFile(static::$baseDir.static::$Controller);
		$this->getFile(static::$baseDir.static::$Auth);
		$this->getFile(static::$baseDir.static::$App);
		$this->getFile(static::$baseDir.static::$Database);
		$this->getFile(static::$baseDir.static::$Vendor);
		return $this;
	}
}