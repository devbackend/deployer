<?php

namespace app\tasks;

/**
 * Сьорка фронтенда.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class GulpTask extends AbstractTask {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getStack(): array {
		return [
			'/usr/local/bin/gulp --production',
		];
	}
}