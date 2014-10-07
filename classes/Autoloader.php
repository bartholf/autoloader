<?php
/**
 * Autoloader for PHP
 * Copyright (C) <2014>  Rikard Bartholf <rikard@bartholf.nu>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class Autoloader
{
	/**
	 * Constructor
	 */
	private function __construct()
	{
		$this->addPath(__DIR__);
		spl_autoload_register(array($this, 'load'));
	}

	/**
	 * The collection of base paths that should be searched.
	 *
	 * @var array
	 */
	private $_paths = [];

	/**
	 * The instance of this class
	 *
	 * @var Autoloader
	 */
	private static $_instance;

	/**
	 * Tries load wanted file from any of the paths
	 *
	 * @param string $class
	 * @return boolean
	 */
	private function load($class)
	{
		$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		foreach($this->_paths as $path)
		{
			if (file_exists($filename = sprintf('%s/%s.php', $path, $class)))
			{
				require $filename;

				return true;
			}
		}

		return false;
	}

	/**
	 * Translates ~ sign to webroot for passed pathname
	 *
	 * @param string $path
	 * @return string
	 */
	private static function parsePath($path)
	{
		return rtrim(preg_replace('/^~/', $_SERVER['DOCUMENT_ROOT'], $path), '/');
	}

	/**
	 * Adds passed paths to the collection
	 *
	 * @param mixed $path
	 * @return Autoloader
	 */
	public function addPath($path)
	{
		foreach ( is_array($path) ? $path : func_get_args() as $v )
		{
			if (! in_array($path = self::parsePath($v), $this->_paths))
			{
				$this->_paths[] = $path;
			}
		}

		return $this;
	}

	/**
	 * Gets the instance of Autoloader
	 *
	 * @return Autoloader
	 */
	public static function instance()
	{
		return self::$_instance ?  : (self::$_instance = new self());
	}
}

return Autoloader::instance();
