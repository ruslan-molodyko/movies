<?php
	
	//Класс предназначенный для инициализации конфигурации и доступа к ее параметрам
	class App{
		
		static private $instance = null;
		private $params = [];
		
		private function __construct(){}
		
		static function getInstance(){
			if(!self::$instance)
				self::$instance = new self();
			return self::$instance;
		}
		
		static function get($k){
			$o = self::getInstance();
			if(isset($o->params[$k])){
				return $o->params[$k];
			}
			throw new Exception("Undefined property {$k}!!!");
		}
		
		//Вызывается при запуске приложения
		function init(){
			$params = include_once('conf.php');
			$this->params = $params;
		}
		
		//Ф. обратного вызова для подключения классов
		static function autoload_callback($class_name){
			foreach(App::get('include_path') as $v){
				$pathToClass = App::get('base_path').$v.DIRECTORY_SEPARATOR.$class_name.'.php';
				if(file_exists($pathToClass)){
					require_once($pathToClass);
				}
			}	
		}
	}