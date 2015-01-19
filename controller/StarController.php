<?php
	
	//Класс для работы с актерами
	class StarController extends Controller{
		
		public $defaultAction = 'list';
		
		function addAction(){
			
			//Если пришли данные с поста создаем актера
			if($this->getRequest()->isPost()){
				
				$first_name = $this->getRequest()->get('first_name');
				$last_name = $this->getRequest()->get('last_name');
				
				$res = Stars::findByAttribute(['first_name'=>trim($first_name),'last_name'=>trim($last_name)]);
				if(!empty($res)){
					$this->getRequest()->setFeedBack('Такой актер уже существует');
					$this->redirect(['star','list']);
				}else{				
					$star = new Stars();
					$star->first_name = $first_name;
					$star->last_name = $last_name;
					$id_star = $star->save();
				}
				
				if($this->getRequest()->get('movie')){
					$arr_list_movie = $this->getRequest()->get('movie');
					foreach($arr_list_movie as $v){
						if($v){
							$id_movie = $v;
							$ms = new Movie_star();
							$ms->id_movie = $id_movie;
							$ms->id_star = $id_star;
							$ms->save();
						}
					}
				}
				$this->getRequest()->setFeedBack('Актер добавлен');
				$this->redirect(['star','list']);
			}
			
			//Берем все фильмы в которых снимался актер
			$list_movies = Movies::findByAttribute([],[],['title','id']);
			$this->render('star.add',['movies_obj'=>$list_movies]);
		}
		
		function listAction(){
			$like = [];
			if($this->getRequest()->get('like')!==null){
				$like = ['first_name',$this->getRequest()->get('like')];
			}
			$order = ['first_name',(bool)$this->getRequest()->get('order')];
			$this->render('star.list',['array_obj'=>Stars::findAll($order,$like)]);
		}
		
		function showAction(){
			$id = $this->getRequest()->get('id');
			$arr_obj = Stars::findBySqlToClass(Movie_star::sqlGetMoviesToIdStar(),array(':id'=>$id));
			$out_movie_list = $this->render('star.list_movies',['array_obj'=>$arr_obj],false,false);
			$this->render('star.show',['obj'=>Stars::findById($id),'out_movie_list'=>$out_movie_list]);
		}
		
		function deleteAction(){
			$id = $this->getRequest()->get('id');
			Stars::delete($id);
			Movie_star::deleteByAttribute(['id_star'=>$id]);
			$this->getRequest()->setFeedBack('Актер удален');
			$this->redirect(['star','list']);
		}
	}