<?php

namespace app\helpers;

use Exception;

/**
 * Хелпер для работы с файловой системой.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class FileSystemHelper extends Helper {
	/** @var static */
	private static $instance;

	/** @var string Директория, в которую будет сохранён релиз */
	private $releaseDir;

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function instance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Получение пути корня приложения.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function root(): string {
		return dirname(dirname(__DIR__));
	}

	/**
	 * Получение пути web-директории приложения.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function web(): string {
		return $this->root() . '/web';
	}

	/**
	 * Получении директории, куда будут сохранены логи релиза.
	 *
	 * @return string
	 *
	 * @throws Exception
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function releaseDir(): string {
		if (null === $this->releaseDir) {
			$this->releaseDir = implode(DIRECTORY_SEPARATOR, [
				$this->web(),
				'releases',
				'.logs',
				time()
			]);

			if (true === file_exists($this->releaseDir)) {
				throw new Exception('Директория ' . $this->releaseDir . ' уже существует!');
			}

			if (false === mkdir($this->releaseDir, 0775)) {
				throw new Exception('Не удалось создать директорию ' . $this->releaseDir);
			}
		}

		return $this->releaseDir;
	}

	/**
	 * Получение пути до директории с настройками серверов.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function config(): string {
		return $this->root() . '/config';
	}
}