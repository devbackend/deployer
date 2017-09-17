<?php

use app\controllers\DeployController;

/**
 * Файл для обработки вебхуки.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

require_once '../vendor/autoload.php';

//-- Отправляем в репозиторий ответ о том, что webhook принят
ob_start();

header('Connection: close');
header('Content-Length: ' . ob_get_length());

echo 'Ok';

ob_end_flush();
ob_flush();
flush();
//-- -- -- --

$controller = new DeployController();

try {
	$controller->run();
}
catch (Exception $e) {
	echo get_class($e) . ': ' . $e->getMessage() . ' on ' . $e->getFile() . ':' . $e->getLine();
}
