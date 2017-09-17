<?php

use app\models\Release;

/**
 * Шаблон списка релизов.
 *
 * @var Release[] $releases
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$tasks = [
	'deploy',
	'git',
	'composer',
	'migrate',
	'yarn',
	'gulp',
];

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Deploy Service</title>

	<link rel="stylesheet" href="/assets/css/materialize.min.css">
	<link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="blue-grey darken-4">

<div class="row">
	<div class="col s2 release-nav">
		<ul>
			<?php foreach ($releases as $key => $release): ?>
				<li>
					<a href="javascript:" data-release-key="<?= $key ?>" class="<?= (0 === $key ? 'active' : '') ?>">
						<?php if (true === $release->handling): ?>
							<div class="progress">
								<div class="indeterminate"></div>
							</div>
						<?php endif ?>

						<span>
							<b><?= $release->branch ?></b>
							<small>(<?= $release->execTime() ?> с)</small>
						</span>

						<span>
							<?= date('d.m.Y H:i:s', strtotime($release->time)) ?>
						</span>

						<span>

						</span>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>

	<div class="col s10">
		<?php foreach ($releases as $key => $release): ?>
			<div class="release <?= (0 === $key ? 'active' : '') ?>" data-release-content="<?= $key ?>">
				<ul class="task-nav">
					<?php foreach ($tasks as $task): ?>
						<?php if (true === $release->hasTask($task)): ?>
							<li>
								<a href="javascript:" data-task="<?= $task ?>" class="<?= ('deploy' === $task ? 'active' : '') ?>"><?= $task ?></a>
							</li>
						<?php endif ?>
					<?php endforeach ?>
				</ul>

				<?php foreach ($tasks as $task): ?>
					<div class="task-content <?= ('deploy' === $task ? 'active' : '') ?>" data-task-content="<?= $task?>">
						<?= $release->showTask($task) ?>
					</div>
				<?php endforeach ?>
			</div>
		<?php endforeach ?>
	</div>
</div>

<script type="text/javascript" src="/assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/assets/js/materialize.min.js"></script>
<script type="text/javascript" src="/assets/js/scripts.js"></script>
</body>
</html>
