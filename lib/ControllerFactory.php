<?php

	/**
	 * Предназначенный для генерации экземпляра контроллера и запуска его action методов на основании Request
	 * 
	 * @package movie.lib
	 * @author Ruslan Molodyko
	 * @todo  Добавить поддержку модулей
	 */
	class ControllerFactory{
		
		/**
		 * Хранит путь к пользовательским контроллерам относительно базовой директории
		 * @var string
		 */
		static $dirToController = 'controller';
	
		/**
		 * Возвращает экземпляр пользовательского контроллера.
		 * На основании значения параметра Request::controller
		 * @param  Request $request Пользовательский запрос
		 *                          Если свойство Request::controller не верно то возвращается дефолтовый контроллер. 
		 *                          Имя которого прописано в конфигурации
		 * @return Controller
		 */
		static function getController(Request $request){
			$controller = empty($request->get('controller')) ? App::get('default_controller') : $request->get('controller');
			if(!preg_match('/\W/',$controller)){
				if(!empty($controller)){
					$controller = UCFirst(strtolower($controller)).'Controller';
					$ds = DIRECTORY_SEPARATOR;
					$basePath = self::$dirToController.$ds.$controller.'.php';
					if(file_exists($basePath)){
						require_once($basePath);
						return new $controller($request);
					}
				}
			}
			throw new Exception("Контроллер {$controller} не найден");
		}

		/**
		 * Вызывает action метод пользовательского контроллера.
		 * На основании значения параметра Request::controller и Request::action
		 * @param  Request $request Пользовательский запрос
		 *                          Если свойство Request::action не верно то запускается дефолтовый action метод. 
		 *                          Имя которого прописано в пользовательском контроллере
		 * @return void
		 */
		static function runAction(Request $request){
			$class = self::getController($request);
			$action = empty($request->get('action')) ? $class->getDefaultAction() : strtolower($request->get('action')).'Action';
			if(!preg_match('/\W/',$action)){
				if(!empty($action)){
					$ref_class = new ReflectionClass($class);
					$ref_method = $ref_class->getMethod($action);
					if(!empty($ref_method)){
						return $class->$action();
					}
				}
			}
			throw new Exception("Action {$action} не найден");
		}
	}