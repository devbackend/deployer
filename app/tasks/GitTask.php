<?php

namespace app\tasks;

/**
 * Команды для работы с git.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class GitTask extends AbstractTask {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getStack(): array {
		return [
			'/usr/bin/git reset --hard',
			'/usr/bin/git pull',
		];
	}
}