<?php

namespace app\controllers;

use app\models\Release;
use app\traits\HelpersTrait;
use Throwable;

/**
 * Контроллер для web-части приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class WebController {
	use HelpersTrait;

	/** @var string[] Имена файлов, которые необходимо исключить при просмотре списка релизов */
	protected static $_excludeReleaseNames = [
		'.',
		'..',
		'.gitignore',
		'.logs',
		'.webhooks',
	];

	/**
	 * Обработка запроса.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handleRequest() {
		$releases = $this->getLastReleases();

		return require $this->fileSystemHelper->web() . '/templates/releases.php';
	}

	/**
	 * Отображение брошенного исключения
	 *
	 * @param Throwable $throwable
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function showException(Throwable $throwable) {
		return require $this->fileSystemHelper->web() . '/templates/error.php';
	}

	/**
	 * Получение последних релизов.
	 *
	 * @param int $count Необходимое количество релизов
	 *
	 * @return Release[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	private function getLastReleases($count = 10) {
		$releasesDir = $this->fileSystemHelper->web() . '/releases';

		$releases = scandir($releasesDir);
		$releases = array_diff($releases, static::$_excludeReleaseNames);
		$releases = array_reverse($releases);
		$releases = array_splice($releases, 0, $count);

		$result = [];
		foreach ($releases as $release) {
			$result[] = unserialize(
				file_get_contents(
					$releasesDir . '/' . $release
				)
			);
		}

		return $result;
	}
}