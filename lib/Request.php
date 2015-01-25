<?php

	/**
	 * Используется для хранения и изменения данных пользовательского запроса
	 * @package movie.lib
	 * @author Ruslan Molodyko
	 */
	class Request{
		/**
		 * Хранит строку URL предыдущей страницы
		 * @var string
		 */
		private $returnUrl;

		/**
		 * Хранит параметры пользовательского запроса
		 * @var array
		 */
		private $params;
		
		/**
		 * Хранит данные о переданных файлах в пользовательском запросе
		 * @var array
		 */
		private $file;

		/**
		 * Хранит ответ системы для пользователя
		 * @var string
		 * @todo  Добавить поддержку сохранения множества значений
		 */
		private $feedBack;
		
		/**
		 * Инициализация данными запроса
		 */
		function __construct(){
			$this->isGet = !empty($_GET);
			$this->isPost = !empty($_POST);
			$this->isFile = !empty($_FILES);
			$this->params = array_merge($_GET,$_POST);
			$this->file = isset($_FILES)?$_FILES:null;
			$this->returnUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
		}
		
		/**
		 * Получить значение параметра запроса
		 * @param  string $k Имя параметра
		 * @return mixed     Если такого параметра не существует выводит null
		 */
		public function get($k){
			if(isset($this->params[$k]))
				return $this->params[$k];
			return null;
		}
		
		/**
		 * Установить значение параметра запроса
		 * @param string $k Имя параметра
		 * @param mixed  $v Значение параметра
		 */
		public function set($k,$v){
			return $this->params[$k] = $v;
		}

		/**
		 * Проверка существуют ли GET параметры в запросе
		 * @return boolean
		 */
		public function isGet(){
			return $this->isGet;
		}
		
		/**
		 * Проверка существуют ли POST параметры в запросе
		 * @return boolean
		 */
		public function isPost(){
			return $this->isPost;
		}

		/**
		 * Проверка существуют ли FILE параметры в запросе
		 * @return boolean
		 */
		public function isFile(){
			return !empty($this->file);
		}
		
		/**
		 * Получить URL предыдущей страницы
		 * @return string
		 */
		public function returnUrl(){
			return $this->returnUrl;
		}
		
		/**
		 * Получить значение параметров FILE
		 * @param  string $k Имя параметра
		 * @return mixed     Если такого параметра не существует выводит null
		 */
		public function getParamFile($k){
			if(isset($this->file[$k]))
				return $this->file[$k];
			return null;
		}
		
		/**
		 * Установить значение для ответа пользователю системой
		 * @param string $str
		 */
		public function setFeedBack($str){
			$this->feedBack = $str;
		}

		/**
		 * Возвратить значение ответа пользователю системой
		 * @return string
		 */
		public function getFeedBack(){
			return $this->feedBack;
		}
		
		/**
		 * Объединяет пользовательские данные и данные запроса
		 * @param array $data Данные которые нужно добавить в Request
		 */
		public function addProp(array $data){
			$this->params = array_merge($data,$this->params);
		}
	}