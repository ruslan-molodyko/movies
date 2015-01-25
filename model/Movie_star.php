<?php

	/**
	 * Модель для работы со связью актера с фильмом
	 * 
	 * @package movie.user.model
	 * @author Ruslan Molodyko
	 */
	class Movie_star extends Model{
		public $id_movie;
		public $id_star;
		
		//Вытащить всех актеров которые снимались в фильме
		static function sqlGetStarsToIdMovie(){
			return "SELECT stars.*, movie_star.id as id_bind FROM stars INNER JOIN movie_star ON movie_star.id_movie = :id AND stars.id = movie_star.id_star";
		}
		
		//Вытащить все фильмы в которых снимались актеры
		static function sqlGetMoviesToIdStar(){
			return "SELECT movies.*, movie_star.id as id_bind FROM movies INNER JOIN movie_star ON movie_star.id_star = :id AND movies.id = movie_star.id_movie";
		}
	}