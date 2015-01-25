<?php

	/**
	 * Выступает как класс с общим функционалом для пользовательских классов
	 *
	 * @package movie.lib
	 * @author Ruslan Molodyko
	 */
	abstract class Controller{
		
		/**
		 * Сохраняет пользовательский Request
		 * @var Request
		 */
		protected $request;

		/**
		 * Задает имя макета который будет 
		 * использоваться в пользовательских классах
		 * @var string
		 */
		public $layout = 'default';

		/**
		 * Имя action метода по умолчанию
		 * @var string
		 */
		public $defaultAction = 'list';

		/**
		 * Сохраняет значение текущего URI
		 * @var string
		 */
		public $currentUri;
		
		/**
		 * Конструктор сохраняет пользовательский Request
		 * и устанавливает текущий URI
		 * @param Request $request Текущий пользовательский запрос
		 */
		function __construct(Request $request){
			$this->request = $request;
			$this->currentUri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		
		/**
		 * Получить текущий URI
		 * @return string
		 */
		function getCurrentUri(){
			return $this->currentUri;
		}
		
		/**
		 * Получить имя action метода по умолчанию
		 * @return string
		 */
		function getDefaultAction(){
			return $this->defaultAction.'Action';
		}
		
		/**
		 * Получить пользовательский запрос
		 * @return Request
		 */
		function getRequest(){
			return $this->request;
		}
		
		/**
		 * Метод для работы с представлениями
		 * Используется для разных вариантов вывода представлений
		 * И возможности подключения к ним макета
		 * 
		 * @param  string  $view      Имя представления, при вызове использовать точечную нотацию. 
		 *                            Например "movie.add" - где "movie" это директория где находится представление "add". 
		 *                            Базовая директория app_base_path/views/
		 * @param  array   $data      Переменная которой присваиваются переданные данные. 
		 *                            В представлении нужно использовать переменную $data
		 * @param  boolean $output    Выводить представление в поток или возвратить как результат метода
		 * @param  boolean $useLayout Использовать макет заданный в свойстве $layout. 
		 *                            Если макет используется то для представление будет вставляться в переменную $content
		 * @return string             Если задан вывод не в поток а как результат метода
		 */
		function render($view,$data = null,$output = true,$useLayout = true){
			try{
				$basePath = App::get('base_path').'view';
				$secondPartPath = preg_replace('/\./',DIRECTORY_SEPARATOR,$view);
				$fullPath = $basePath.DIRECTORY_SEPARATOR.$secondPartPath.'.php';
				if(file_exists($fullPath)){
					if($useLayout){
						ob_start();
							include $fullPath;
							$content = ob_get_contents();
						ob_end_clean();
						$pathToLayout = $basePath.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR;
						$pathToLayout.= $this->layout.'.php';

						if(!file_exists($pathToLayout)){
							throw new Exception('Не найден макет'.$pathToLayout);
						}
						ob_start();
							include $pathToLayout;
							$return = ob_get_contents();
						ob_end_clean();
						
						if($output){
							echo $return;
						}else{
							return $return;
						}
					}else{
						if($output){
							include $fullPath;
						}else{
							ob_start();
								include($fullPath);
								$include = ob_get_contents();
							ob_end_clean();
							return $include;
						}
					}
				}else{
					throw new Exception('Представления не существует'.$fullPath);
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		/**
		 * Метод для редиректа приложения на нужный URL
		 * Если в пользовательском запросе есть ответ (feedback) системе 
		 * то он будет послан в строке запроса в переменной feedback
		 * @param  mixed $url  Может быть array тогда ключ "0" 
		 *                     указывает на имя пользовательского контроллера. 
		 *                     А ключ "1" указывает на имя action метода.
		 *                     Если string то редирект происходит строго по этой строке.
		 *                     Если ничего не передано в качестве параметра то редирект на предыдущую страницу
		 * @todo Нужно добавить вариант когда реферер не существует ибо тогда происходит ошибка
		 */
		public function redirect($url){
			$str = '?';
			if(is_array($url)){
				if(isset($url[0]))
					$str .= 'controller='.$url[0].'&';
				if(isset($url[1]))
					$str .= 'action='.$url[1];
					$str ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$str;
			}else if($url){
				$str = $url;
			}else{
				$str = $_SERVER['HTTP_REFERER'];
			}
			if($this->getRequest()->getFeedBack()){
				$str .= '&feedback='.$this->getRequest()->getFeedBack();
			}
			header("Location: ".$str);
		}
	}