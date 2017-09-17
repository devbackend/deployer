<?php
/**
 * Шаблон страницы исключения.
 *
 * @var Throwable $throwable
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Error</title>
</head>
<body style="text-align: center;">

	<h1 style="color: #f00;"><?= $throwable->getMessage() ?></h1>

	<p><b>Файл:</b> <?= $throwable->getFile() ?>:<?= $throwable->getLine() ?></p>

	<div>
		<?= $throwable->getTraceAsString() ?>
	</div>

</body>
</html>