<?php

namespace app\controllers;

use app\traits\HelpersTrait;
use AuthGramRequestHandler\AuthGramRequestHandler;

/**
 * Контроллер для работы с авторизацией.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthController {
	use HelpersTrait;

	/**
	 * Обработка запроса от бота.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handleBotRequest() {
		$requestHandler = new AuthGramRequestHandler($this->authHelper->getToken());

		if (false === $requestHandler->isValidToken()) {
			return;
		}

		$request = $requestHandler->getRequest();

		/*if (false === $this->authHelper->can($request->user->uuid)) {
			return;
		}*/

		file_put_contents(
			$this->fileSystemHelper->web() . DIRECTORY_SEPARATOR . '.auth' . DIRECTORY_SEPARATOR . $request->authKey,
			serialize($request->user)
		);
	}
}