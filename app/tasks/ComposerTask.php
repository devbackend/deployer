<?php

namespace app\tasks;

/**
 * Команда для обновления зависимостей Composer'а.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ComposerTask extends AbstractTask {
	public function getStack(): array {
		return [
			'/usr/bin/composer install',
		];
	}
}