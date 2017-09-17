<?php

namespace app\traits;

use app\helpers\FileSystemHelper;
use app\helpers\StringHelper;

/**
 * Примесь для работы с хелперами.
 *
 * @property-read FileSystemHelper  $fileSystemHelper    Хелпер для работы с файловой системой
 * @property-read StringHelper      $stringHelper        Хелпер для работы со строками
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
trait HelpersTrait {
	protected static $_helpers = [];

	/**
	 * Обработчик магических свойств.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __get($name) {
		if (false === array_key_exists($name, static::$_helpers)) {
			$helperClass = '\\app\\helpers\\' . ucfirst($name);
			$helper = null;
			if (class_exists($helperClass)) {
				$helper = $helperClass::instance();
			}

			static::$_helpers[$name] = $helper;
		}

		return static::$_helpers[$name];
	}
}