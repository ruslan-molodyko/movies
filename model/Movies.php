<?php

	/**
	 * Класс для работы с фильмами
	 * 
	 * @package movie.user.model
	 * @author Ruslan Molodyko
	 */
	class Movies extends Model{
		public $title;
		public $year;
		public $format = ['VHS','DVD','Blu-Ray'];
	}