<?php

	//Класс для работы с фильмами
	class Movies extends Model{
		public $title;
		public $year;
		public $format = ['VHS','DVD','Blu-Ray'];
	}