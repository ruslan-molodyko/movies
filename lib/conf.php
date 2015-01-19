<?php
	return [
			'path_init_db'=>'mysql:host=localhost;dbname=movie_db',
			'user_db'=>'root',
			'password_db'=>'muha1990',

			'app_name'=>'Веб-приложение для хранения информации о фильмах',

			'default_controller'=>'movie',
			'base_path'=>$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR,
			'include_path'=>['lib','controller','model']
		];
