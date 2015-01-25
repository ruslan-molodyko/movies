<?php

	require_once('App.php');

	/**
	 * Предназначенный для инициализации и запуска приложения
	 * 
	 * Выполнен на основании шаблона Singleton
	 * Выступает как точка входа пользовательского запроса
	 * 
	 * @package movie.lib
	 * @author Ruslan Molodyko
	 */
	class AppController{
		/**
		 * Хранит экземпляр класса
		 * @var AppController
		 */
		static private $instance = null;
		
		/**
		 * Закрытый конструктор для реализации Singleton
		 */
		private function __construct(){}

		/**
		 * Метод для вызова экземпляра класса
		 * @return AppController
		 */
		function getInstance(){
			if(!self::$instance)
				self::$instance = new self();
			return self::$instance;
		}

		/**
		 * Метод для запуска приложения
		 */
		static public function run(){
			$controller = AppController::getInstance();
			$controller->init();
			$controller->process();
		}

		/**
		 * Метод для инициализации конфигурации
		 */
		function init(){
			$conf = App::getInstance();
			$conf->init();
			spl_autoload_register(array('App','autoload_callback'));
		}

		/**
		 * Запуск пользовательского контроллера
		 */
		function process(){
			try{
				$request = new Request();
				$action = ControllerFactory::runAction($request);
			}catch(Exception $e){
				echo '<strong>Произошла непредвиденная ошибка!</strong>';
			}
		}
	}