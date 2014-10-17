<?php
/**
 * Singleton mechanism for PHP
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
namespace Rib;

use \ReflectionClass;

abstract class SingletonProvider
{
	public static function instance()
	{
		$class = get_called_class();

		return ($object = SingletonProviderStore::get($class))
			? $object
			: SingletonProviderStore::set($class, new $class);
	}
}

final class SingletonProviderStore
{
	private static $_cache = array();

	public static function set($key, $object)
	{
		return self::$_cache[$key] = $object;
	}

	public static function get($key)
	{
		return isset(self::$_cache[$key]) ? self::$_cache[$key] : null;
	}
}
