<?php

namespace app\helpers;

use Webhooker\wrappers\User;

/**
 * Хэлпер для работы с авторизацией пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthHelper extends Helper {
	const APPLICATION_UUID  = '76d7dab0-9b93-11e7-8678-8f8107f8e383';
	const AVAILABLE_UUID    = '5da30b90-f0e3-11e6-93b7-3bcf57257ab3';
	const TOKEN             = '44e3b2f8510362acebbb8eb5cf49edcb4tdzm21b3scllzoe7lna9gzw0u14';
	const COOKIE_KEY_NAME   = 'deployer-ag';

	/** @var static */
	private static $instance;

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
	 * Проверка авторизации пользователя.
	 *
	 * @return bool
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function check(): bool {
		// -- Проверка, возможно авторизация совершена в данный момент
		if (false !== array_key_exists('auth_key', $_GET)) {
			$authFilePath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . '.auth' . DIRECTORY_SEPARATOR . $_GET['auth_key'];
			if (true === file_exists($authFilePath)) {
				$user = file_get_contents($authFilePath);
				$user = unserialize($user);/** @var User $user */

				if (true === $this->can($user->uuid)) {
					setcookie(static::COOKIE_KEY_NAME, $user->uuid, time() + 86400 * 7);

					return true;
				}
			}
		}
		// -- -- -- --

		return (true === array_key_exists(static::COOKIE_KEY_NAME, $_COOKIE)
			&& true === $this->can($_COOKIE[static::COOKIE_KEY_NAME])
		);
	}

	/**
	 * Отрисовка виджета авторизации.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function drawWidget(): string {
		exit('<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Авторизация</title>
</head>
<body>

	<button data-role="authgram-sign-button" class="authgram-sign-button"><span>Войти через Telegram</span></button>
	
	<script type="text/javascript" src="https://cdn.authgram.ru/js/authgram-widget.js"></script>
	<script type="text/javascript">
		var AuthGramWidget = new AuthGramWidget(\'76d7dab0-9b93-11e7-8678-8f8107f8e383\');
	</script>

</body>
</html>');
	}

	/**
	 * Получение значения токена.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getToken(): string {
		return static::TOKEN;
	}

	/**
	 * Доступна ли авторизация пользователю.
	 *
	 * @param string $uuid
	 *
	 * @return bool
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function can(string $uuid): bool {
		return (static::AVAILABLE_UUID === $uuid);
	}
}