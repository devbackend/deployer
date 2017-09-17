<?php

namespace app\tasks;

use Webhooker\wrappers\webhooks\PushWebhook;

/**
 * Родтельский класс для задач.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class AbstractTask {
	/** @var PushWebhook Данные webhook'и */
	protected $webhook;

	/**
	 * Получение очереди консольных команд.
	 * Команды выполняются по порядку.
	 * Если в качестве очередной команды возвращён массив, то входящие в него команды будут выполняться параллельно
	 *
	 * @return string[]|string[][]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	abstract public function getStack(): array;

	/**
	 * Установка webhook'и
	 *
	 * @param PushWebhook $webhook
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setWebhook($webhook) {
		$this->webhook = $webhook;

		return $this;
	}
}