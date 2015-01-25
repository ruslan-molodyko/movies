<?php
	/**
	 * Предоставляет доступ к данным приложения
	 * 
	 * Выполнен на основании шаблона Registry
	 * и отвечает за инициализацию и доступ к конфигурации
	 * 
	 * @package movie.lib
	 * @author Ruslan Molodyko
	 */
	class App{
		/**
		 * Хранит экземпляр класса 
		 * @var App
		 */
		static private $instance = null;

		/**
		 * Хранит переменные конфигурации
		 * @var mixed
		 */
		private $params = [];

		/**
		 * Закрытый конструктор для реализации Singleton
		 */
		private function __construct(){}

		/**
		 * Получить экземпляр класса
		 * @return App
		 */
		static function getInstance(){
			if(!self::$instance)
				self::$instance = new self();
			return self::$instance;
		}

		/**
		 * Получить значение параметра конфигурации
		 * @param  string $k Имя параметра
		 * @return mixed    Возвращает значение параметра
		 */
		static function get($k){
			$o = self::getInstance();
			if(isset($o->params[$k])){
				return $o->params[$k];
			}
			throw new Exception("Неопределенная переменная {$k}!!!");
		}

		/**
		 * Инициализация класса
		 * Вызывается в начале работы приложения
		 * Предназначено для инициализации данных конфигурации 
		 * если они не хранятся во встроенных структурах языка 
		 * а получаются из внешних источников
		 */
		function init(){
			$params = include_once('conf.php');
			$this->params = $params;
		}

		/**
		 * Метод обратного вызова для подключения классов
		 * 
		 * @param  string $class_name
		 * @todo Этот метод не должен здесь находится, это не логика данного класса
		 */
		static function autoload_callback($class_name){
			foreach(App::get('include_path') as $v){
				$pathToClass = App::get('base_path').$v.DIRECTORY_SEPARATOR.$class_name.'.php';
				if(file_exists($pathToClass)){
					require_once($pathToClass);
				}
			}
		}
	}