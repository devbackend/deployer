<?php

use app\controllers\WebController;

/**
 * Входная точка web-приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

require '../vendor/autoload.php';

$controller = new WebController();

try {
	$controller->handleRequest();
}
catch (Throwable $e) {
	$controller->showException($e);
}