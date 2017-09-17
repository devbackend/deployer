<?php

namespace app\controllers;

use app\components\Connection;
use app\components\Logger;
use app\models\Release;
use app\ServerConfig;
use app\traits\HelpersTrait;
use Webhooker\PushWebhookHandler;
use Webhooker\wrappers\webhooks\PushWebhook;

/**
 * Контроллер для обработки и проведения деплоя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DeployController {
	use HelpersTrait;

	/** @var Logger Компонент логирования */
	public $logger;

	/** @var Connection Компонент соединения */
	public $connection;

	/** @var PushWebhook Данные web-хуки */
	protected $webhook;

	/** @var Release Инстанс релиза */
	private $release;

	/**
	 * Запуск процесса деплоя.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function run() {
		$webhookHandler = PushWebhookHandler::init();
		$this->webhook  = $webhookHandler->getWebhook();

		// -- Проверяем - есть ли обработчики для хуки
		$config = $this->getConfig();
		if (null === $config) {
			return;
		}
		// -- -- -- --

		$this->logger   = new Logger();
		$this->release  = new Release();

		// -- Сохраним пришедшие данные чтобы потом в случае необходимости их можно было просмотреть
		$hookFilename = microtime(true) . '.json';
		$webhookFile  = $this->fileSystemHelper->web() . '/releases/.webhooks/' . $hookFilename;
		file_put_contents($webhookFile, $webhookHandler->getRaw());
		$this->logger->write('Данные вебхуки записаны в файл ' . $hookFilename);
		// -- -- -- --

		// -- Проставляем данные релиза
		$this->release->project     = $this->webhook->repository->name;
		$this->release->branch      = $this->webhook->push->changes[0]->new->name;
		$this->release->time        = $this->webhook->push->changes[0]->new->target->date;
		$this->release->author      = $this->webhook->push->changes[0]->new->target->author->raw;
		$this->release->logsDir     = $this->fileSystemHelper->releaseDir();
		$this->release->startTime   = time();
		// -- -- -- --

		$this->saveReleaseState();

		$this->logger->write('Начало релиза');
		$this->handleServer($config);
		$this->logger->write('Завершение релиза');

		$this->release->handling = false;
		$this->release->endTime  = time();

		$this->saveReleaseState();
	}

	/**
	 * Получение конфига для деплоя.
	 *
	 * @return ServerConfig|null
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function getConfig() {
		$repository = strtolower($this->webhook->repository->name);

		$configFile = $this->fileSystemHelper->config() . DIRECTORY_SEPARATOR . $repository . '.php';
		if (false === file_exists($configFile)) {
			return null;
		}

		$config = require $configFile;

		$branch = $this->webhook->push->changes[0]->new->name;
		if (false === array_key_exists($branch, $config)) {
			return null;
		}

		return $config[$branch];
	}

	/**
	 * Обработка настроек сервера и выполнение команд.
	 *
	 * @param ServerConfig $serverConfig
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function handleServer(ServerConfig $serverConfig) {
		$connectionConfig = [
			Connection::PARAM_SERVER    => $serverConfig->getAddress(),
			Connection::PARAM_LOGIN     => $serverConfig->getLogin(),
			Connection::PARAM_PASSWORD  => $serverConfig->getPassword(),
			Connection::PARAM_ROOT_DIR  => $serverConfig->getRootDir(),
		];

		$this->connection = new Connection($connectionConfig);

		foreach ($serverConfig->getTasks() as $task) {
			$this->logger->write('Запущено задание ' . get_class($task));
			$this->connection->runTask($task);
			$this->logger->write('Завершено задание ' . get_class($task));
		}
	}

	/**
	 * Сохранение состояния релиза.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function saveReleaseState() {
		file_put_contents(
			$this->fileSystemHelper->web() . DIRECTORY_SEPARATOR . 'releases' . DIRECTORY_SEPARATOR . $this->release->startTime . '.release',
			serialize($this->release)
		);
	}
}