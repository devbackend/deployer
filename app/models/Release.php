<?php

namespace app\models;

/**
 * Класс для описания релиза.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Release {
	/** @var bool Релиз в процессе накатывания */
	public $handling = true;

	/** @var string Ветка релиза */
	public $branch;

	/** @var string Время релиза */
	public $time;

	/** @var string Автор релиза */
	public $author;

	/** @var string Директория с логами релиза */
	public $logsDir;

	/** @var int Время начала релиза */
	public $startTime;

	/** @var int Время завершения релиза */
	public $endTime;

	/**
	 * Время исполнения (в секундах)
	 *
	 * @return int
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function execTime() {
		return (null !== $this->endTime ? $this->endTime - $this->startTime : time() - $this->startTime);
	}

	/**
	 * Есть ли задание
	 *
	 * @param string $task
	 *
	 * @return bool
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function hasTask(string $task): bool {
		return file_exists($this->logsDir . '/' . $task . '.log');
	}

	/**
	 * Отобразить содержимое задания.
	 *
	 * @param string $task
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function showTask(string $task): string {
		return (true === $this->hasTask($task)
			? nl2br(file_get_contents($this->logsDir . '/' . $task . '.log'))
			: ''
		);
	}
}