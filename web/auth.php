<?php
/**
 * Обработка авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

require '../vendor/autoload.php';

(new \app\controllers\AuthController())->handleBotRequest();