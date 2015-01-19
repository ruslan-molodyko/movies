<?php
	//Класс для загрузки и распознания файла с данными
	class ParseController extends Controller{
		
		public $defaultAction = 'index';
		
		//На этот метод приходит файл с клиента
		function uploadAction(){
			try{
				$request = $this->getRequest();
				if($request->isFile()){
					if($request->getParamFile('file')&&isset($request->getParamFile('file')['tmp_name'])){
						$lines = $this->getDataArray($this->getRequest()->getParamFile('file')['tmp_name']);
						if(is_array($lines)){
							$this->parse($lines);
							echo 'Данные успешно загружены';
							exit;
						}
					}
				}
			}catch(Exception $e){
				echo 'Произошла ошибка!';
			}
			echo 'Произошла ошибка!';
		}		
				
		function indexAction(){
			$this->render('parse.index');
		}
		
		function getDataArray($pathToFile){
			if(file_exists($pathToFile)){
				$lines = file($pathToFile);
				return $lines;
			}
			throw new Exception('Файл не найден!');
		}
		
		//Метод для обработки массива строк
		function parse(array $lines){
			try{
				$i = 0;
				$key = ['title','year','format','star'];
				$data = [];
				$count = count($lines);
				for($j = 0; $j<$count; $j++){
					$v = $lines[$j];
					
					//Если блок с одним фильмом закончился имитируем $request и добавляем новый фильм
					if(empty(trim($v))){
						if(isset($lines[$j+1])&&empty(trim($lines[$j+1]))) continue;
						$request = new Request();
						$request->set("controller","movie");
						$request->addProp($data);
						$movieController = ControllerFactory::getController($request);
						//Создание фильма
						$movieController->addMovie($request);
						
						//Чистим данные и приступаем к новому блоку
						$data = [];
						$i = 0;
						continue;
					}
					
					//Если это актеры то парсим их
					$value = explode(':',$v);
					if(isset($value[0])&&($value[0]=='Stars')){
						$item = explode(',',trim($value[1]));
						$star = [];
						foreach($item as $v){
							$st_data = explode(' ',trim($v));
							$star[] = ['first_name'=>trim($st_data[0]), 'last_name'=>trim($st_data[1].(isset($st_data[2])?' '.$st_data[2]:'')) ];
						}
						$data['star'] = $star;
						continue;
					}
					
					//Заливаем соответствующие данные в массив 
					$data[$key[$i]] = trim($value[1]);
					$i++;	
				}
			}catch(Exception $e){
				throw new Exception("Ошибка при обработке документа!");
			}
		}
	}