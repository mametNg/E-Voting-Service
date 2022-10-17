<?php

class startApp
{
	private static $loader;

	public static function loadClassLoader($class)
    {
        if ('Terminate\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

	public static function getLoader($value='')
	{
		if (null !== self::$loader) {
            return self::$loader;
        }
        
		require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('startApp', 'loadClassLoader'), true, true);

        self::$loader = $loader = new \Terminate\Autoload\ClassLoader(\dirname(\dirname(__FILE__)));

        self::$loader->start();

        return $loader;
	}
	
}