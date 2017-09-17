<?php

namespace app\tasks;

/**
 * Миграции.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class MigrateTask extends AbstractTask {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getStack(): array {
		return [
			'/usr/bin/php artisan migrate --force',
		];
	}
}