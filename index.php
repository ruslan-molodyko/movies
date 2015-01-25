<?php
	/**
	 * Файл с которого начинает работу приложение
	 * 
	 * @license http://www.exmple.com
	 * @package movie.file
	 */

	/**
	 * Подключаем контроллер приложения
	 */
require_once('lib/AppController.php');
	
	/**
	 * Запускаем приложение!
	 */
	AppController::run();