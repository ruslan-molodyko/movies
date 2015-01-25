<?php
	
	/**
	 * Класс для работы со связью актера и фильма
	 * 
	 * @package movie.user.controller
	 * @author Ruslan Molodyko
	 */
	class MovieStarController extends Controller{
		function deleteAction(){
			Movie_star::delete($this->getRequest()->get('id'));
			$this->getRequest()->setFeedBack('Удален');
			$this->redirect($this->getRequest()->returnUrl());
		}
	}