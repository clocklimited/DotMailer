<?php

class AutoLoader {
	/**
	 * Autoload classes
	 */
	public static function register($basePath) {
		spl_autoload_register(function($className) use ($basePath) {
			$classPath = str_replace("\\", "/", $className . ".php");
			if (is_readable($basePath . $classPath)) {
				require $basePath . $classPath;
			} else if (is_readable($basePath . "../" . $classPath)) {
				require $basePath . "../" . $classPath;
			}
		});
	}
}

$path = realpath(dirname(__FILE__) . "/..");
ini_set("include_path", ".:{$path}:{$path}:/usr/lib/php/pear:/usr/share/php");
require_once("PHPUnit/Autoload.php");
AutoLoader::register("{$path}/");
