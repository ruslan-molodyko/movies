<?php

	require_once('App.php');

	//Класс предназначенный для инициализации и запуска приложения   
	class AppController{
		
		static private $instance = null;
		
		private function __construct(){}
		
		function getInstance(){
			if(!self::$instance)
				self::$instance = new self();
			return self::$instance;
		}
		
		static public function run(){
			$controller = AppController::getInstance();
			$controller->init();
			$controller->process();
		}
		
		//Инициализация конфигурации
		function init(){
			$conf = App::getInstance();
			$conf->init();
			spl_autoload_register(array('App','autoload_callback'));
		}
		
		//Запуск контроллера
		function process(){
			try{
				$request = new Request();
				$action = ControllerFactory::runAction($request);
			}catch(Exception $e){
				echo '<strong>Произошла непредвиденная ошибка!</strong>';
			}
		}
	}