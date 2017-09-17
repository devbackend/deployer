<?php

namespace app;

use app\tasks\AbstractTask;

/**
 * Настройки сервера для деплоя приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ServerConfig {
	/** @var string Адрес сервера */
	private $address;

	/** @var string Логин для подключения к серверу */
	private $login;

	/** @var string Пароль для подключения к серверу */
	private $password;

	/** @var string RSA-ключ для подключения к серверу */
	private $rsaKey;

	/** @var string Корневая директория сервера */
	private $rootDir = '/';

	/** @var AbstractTask[] Список заданий, которые необходимо выполнить на сервере */
	private $tasks = [];

	/**
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getAddress(): string {
		return $this->address;
	}

	/**
	 * @param string $address
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setAddress(string $address) {
		$this->address = $address;

		return $this;
	}

	/**
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getLogin(): string {
		return $this->login;
	}

	/**
	 * @param string $login
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setLogin(string $login) {
		$this->login = $login;

		return $this;
	}

	/**
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getPassword(): string {
		return $this->password;
	}

	/**
	 * @param string $password
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setPassword(string $password) {
		$this->password = $password;

		return $this;
	}

	/**
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getRsaKey(): string {
		return $this->rsaKey;
	}

	/**
	 * @param string $rsaKey
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setRsaKey(string $rsaKey) {
		$this->rsaKey = $rsaKey;

		return $this;
	}

	/**
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getRootDir(): string {
		return $this->rootDir;
	}

	/**
	 * @param string $rootDir
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setRootDir(string $rootDir) {
		$this->rootDir = $rootDir;

		return $this;
	}

	/**
	 * @return AbstractTask[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getTasks() {
		return $this->tasks;
	}

	/**
	 * Добавление задачи в список.
	 *
	 * @param AbstractTask $task
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function addTask(AbstractTask $task) {
		$this->tasks[] = $task;

		return $this;
	}
}