<?php

namespace app\helpers;

/**
 * Абстрактный класс хэлпера
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class Helper {
	/**
	 * Закрываем конструктор
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function __construct() {}

	/**
	 * Получение инстанса
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	abstract public static function instance();
}