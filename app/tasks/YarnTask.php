<?php

namespace app\tasks;

/**
 * Команда для обновления зависимостей yarn.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class YarnTask extends AbstractTask {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getStack(): array {
		return [
			'/usr/local/bin/yarn install',
		];
	}
}