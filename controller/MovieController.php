<?php
	
	/**
	 * Класс для работы с фильмами
	 * 
	 * @package movie.user.controller
	 * @author Ruslan Molodyko
	 */
	class MovieController extends Controller{
		
		public $defaultAction = 'list';
		
		function addAction(){
			
			//Если пришли данные с поста создаем фильм
			if($this->getRequest()->isPost()){
				
				$this->addMovie($this->getRequest());
				$this->getRequest()->setFeedBack('Фильм добавлен');
				$this->redirect(['movie','list']);
			}
			
			//Создание удобных данных для роботы jQuery библиотеки autocomplete
			$list_stars = Stars::findAll();
			foreach($list_stars as &$v){
				$v = $v->first_name.' '.$v->last_name;
			}
			$this->render('movie.add',['stars_obj'=>json_encode($list_stars)]);
		}
		
		function listAction(){
			$like = [];
			if($this->getRequest()->get('like')!==null){
				$like = ['title',$this->getRequest()->get('like')];
			}
			$order = ['title',(bool)$this->getRequest()->get('order')];
			$this->render('movie.list',['array_obj'=>Movies::findAll($order,$like)]);
		}
		
		function showAction(){
			$id = $this->getRequest()->get('id');
			$arr_obj = Stars::findBySqlToClass(Movie_star::sqlGetStarsToIdMovie(),array(':id'=>$id));
			$out_star_list = $this->render('movie.list_stars',['array_obj'=>$arr_obj],false,false);
			$this->render('movie.show',['obj'=>Movies::findById($id),'out_star_list'=>$out_star_list]);
		}
		
		function deleteAction(){
			$id = $this->getRequest()->get('id');
			Movies::delete($id);
			Movie_star::deleteByAttribute(['id_movie'=>$id]);
			$this->getRequest()->setFeedBack('Фильм удален');
			$this->redirect(['movie','list']);
		}
		
		//Добавление фильма и актеров с переданного контекста
		function addMovie(Request $request){
			$movies = new Movies($request);
			$id_movie = $movies->save();
			
			if($request->get('star')){
				$arr_list_star = $request->get('star');
				foreach($arr_list_star as $v){
					if($v){
						if(is_array($v)){
							$first_name = $v['first_name'];
							$last_name = $v['last_name'];
						}else{
							list($first_name,$last_name) = explode(' ',trim($v));
						}
						$res = Stars::findByAttribute(['first_name'=>trim($first_name),'last_name'=>trim($last_name)]);
						if(!empty($res)){
							$id_star = $res[0]->id;
						}else{				
							$star = new Stars();
							$star->first_name = $first_name;
							$star->last_name = $last_name;
							$id_star = $star->save();
						}
						$ms = new Movie_star();
						$ms->id_movie = $id_movie;
						$ms->id_star = $id_star;
						$ms->save();
					}
				}
			}
		}
	}