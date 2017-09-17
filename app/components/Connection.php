<?php

namespace app\components;

use app\tasks\AbstractTask;
use Exception;
use phpseclib\Net\SSH2;

/**
 * Компонент для работы с соединением с удалённым сервером.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Connection extends AbstractComponent {
	const PARAM_SERVER      = 'server';
	const PARAM_LOGIN       = 'login';
	const PARAM_PASSWORD    = 'password';
	const PARAM_RSA_KEY     = 'rsa_key';
	const PARAM_ROOT_DIR    = 'root_dir';

	/** @var SSH2 Открытое соединение */
	private $ssh;

	/** @var string */
	private $rootDir;

	/**
	 * @param string[] $config Настройки соединения.
	 *
	 * @throws Exception
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(array $config) {
		if (false === $this->isAllRequired($config)) {
			throw new Exception('Не указаны все обязательные параметры соединения');
		}

		$this->ssh = new SSH2($config[static::PARAM_SERVER]);

		if (true === array_key_exists(static::PARAM_RSA_KEY, $config)) {
			// @todo-29.07.2017-krivonos.iv логика соединения через ключ
		}
		else {
			$login      = $config[static::PARAM_LOGIN];
			$password   = $config[static::PARAM_PASSWORD];

			if (false === $this->ssh->login($login, $password)) {
				throw new Exception('Не удалось соединиться с сервером');
			}
		}

		if (array_key_exists(static::PARAM_ROOT_DIR, $config) && null !== $config[static::PARAM_ROOT_DIR]) {
			$this->rootDir = $config[static::PARAM_ROOT_DIR];
		}
	}

	/**
	 * Запуск команды.
	 *
	 * @param AbstractTask $task
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function runTask(AbstractTask $task) {
		$taskLog = basename(get_class($task));
		$taskLog = str_replace('Task', '', $taskLog);
		$taskLog = $this->stringHelper->kebabCase($taskLog) . '.log';
		$taskLog = $this->fileSystemHelper->releaseDir() . DIRECTORY_SEPARATOR . $taskLog;

		$logHandler = fopen($taskLog, 'w+');

		foreach ($task->getStack() as $command) {
			if (true === is_array($command)) {
				// @todo-29.07.2017-krivonos.iv паралелльное выполнение команд
			}

			if (null !== $this->rootDir) {
				$command = implode(' && ', [
					'cd ' . $this->rootDir,
					$command
				]);
			}

			fwrite($logHandler, $this->ssh->exec($command));
		}

		fclose($logHandler);
	}

	/**
	 * Проверка, что указаны все обязательные параметры соединения.
	 *
	 * @param array $config
	 *
	 * @return bool
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function isAllRequired(array $config): bool {
		return (array_key_exists(static::PARAM_SERVER, $config)
			&& array_key_exists(static::PARAM_LOGIN, $config)
			&& (array_key_exists(static::PARAM_PASSWORD, $config) || array_key_exists(static::PARAM_RSA_KEY, $config))
		);
	}
}