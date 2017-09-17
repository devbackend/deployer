<?php

namespace app\components;

/**
 * Компонент логирования.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Logger extends AbstractComponent {
	/** @var resource Поток файла */
	protected $file;

	/**
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct() {
		$filename = implode(DIRECTORY_SEPARATOR, [
			$this->fileSystemHelper->releaseDir(),
			'deploy.log',
		]);

		$this->file = fopen($filename, 'w+');
		$this->write('Открытие файла лога');
	}

	/**
	 * Произвести запись в лог.
	 *
	 * @param string $log
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function write(string $log) {
		fwrite($this->file, '[' . date('Y-m-d H:i:s') . '] ' . $log . "\n");
	}

	/**
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __destruct() {
		$this->write('Закрытие файла лога');

		fclose($this->file);
	}
}