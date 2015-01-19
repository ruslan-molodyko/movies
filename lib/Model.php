<?php
	
	//Класс от которого наследуется функционал для пользовательских моделей
	abstract class Model{
		
		function __construct(Request $requestInit = null){
			if($requestInit){
				$this->eachObject($requestInit);
			}
		}
		
		static protected function tableName(){
			return strtolower(get_class(new static()));
		}
		
		//Получаем PDO объект
		static public function getDBHandler(){
			try{
				$DBH = new PDO(App::get('path_init_db'),App::get('user_db'),App::get('password_db'));
				$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				return $DBH;
			}catch(PDOException $e){ 
				echo $e->getMessage();  
			}
		}
		
		static function delete($id){
			$id = (int)$id;
			if($id){
				$STH = self::getDBHandler()->prepare("DELETE FROM ".self::tableName()." WHERE id = :id");
				echo "DELETE FROM ".self::tableName()." WHERE id = :id";
				return $STH->execute([':id'=>$id]);
			}
			return false;
		}
		
		static function deleteByAttribute(array $param = []){
			if(!empty($param)){
				$STH = self::getDBHandler()->prepare("DELETE FROM ".self::tableName().self::strToWhere($param));
				return $STH->execute(self::dataBindToExecute($param));
			}
			return false;
		}
		
		public function insert(){
			$STH = self::getDBHandler()->prepare("INSERT INTO ".self::tableName()." (".$this->objectStringToInsert().") values (".$this->objectStringToInsert('value').")");
			if($STH->execute($this->objectBindToExecute())){
				$STH = self::getDBHandler()->query('SELECT max(id) FROM '.self::tableName());
				$obj = $STH->fetch();
				return $obj[0];
			}else{
				return false;
			}
		}
		
		public function update(){
			if(isset($this->id)){
				if($STH = self::getDBHandler()->prepare('SELECT COUNT(*) FROM '.self::tableName().' WHERE id = :id')){
					$STH->execute([':id'=>$this->id]);
					if($STH->fetchColumn() > 0){  
						$STH = self::getDBHandler()->prepare("UPDATE ".self::tableName()." SET ".$this->objectStringToSet()." WHERE id = :id");
						if($STH->execute(array_merge($this->objectBindToExecute(),[':id'=>$this->id]))){
							return $this->id;
						}else{
							return false;
						}
					}
				}
			}
			throw new Exception('ID не определено!');
		}
		
		static function findAll($order = null,$like = null){
			$STH = self::getDBHandler()->prepare('SELECT '.self::tableName().'.* FROM '.self::tableName().self::strToLikeByFindAll($like).self::strToOrderByFindAll($order));
			if(is_array($like)&&isset($like[1])){
				$like[1] = '%'.$like[1].'%';
				$STH->bindParam(':like', $like[1]);
			}
			$STH->execute();
			$STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::tableName());  
			return self::fetchAndGetObj($STH);
		}
		
		static function findById($id){
			return self::findByAttribute(['id'=>$id]);
		}
		
		static function findByAttribute(array $attr = [],$limit = null,$select = null){
			$select = is_array($select) ? implode(',',$select) : self::tableName().'.*';
			$STH = self::getDBHandler()->prepare('SELECT '.$select.' FROM '.self::tableName().self::strToWhere($attr).self::getStrLimit($limit));
			$STH->execute(self::dataBindToExecute($attr));
			$STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::tableName());  
			return self::fetchAndGetObj($STH);
		}
		
		function save(){
			if(isset($this->id)&&($this->id !== null)){
				return $this->update();
			}else{
				return $this->insert();
			}
		}
		
		static function findBySql($sql = null,array $data = null,$mode = null){
			$STH = self::getDBHandler()->prepare($sql);
			$STH->execute($data);
			if($mode == null){
				$STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::tableName());
			}
			return self::fetchAndGetObj($STH);
		}
		
		static function findBySqlToClass($sql = null,array $data = null){
			return self::findBySql($sql,$data);
		}
		
		//Метод сохраняет в экземпляр модели все значения которые есть в $request
		function eachObject(Request $request){
			$key = $this->getKeyNativeProp();
			foreach($key as $v){
				$this->$v = $request->get($v);
			}
		}
		
		//--------------------------------------------------
		//Вспомогательные методы для создания элементов SQL запроса
		
		static function strToLikeByFindAll($like = null){
			$str = '';
			if(is_array($like)&&isset($like[0])&&isset($like[1])){
				$column = $like[0];
				$str = ' WHERE '.$column.' LIKE :like ';
			}
			return $str;
		}
		
		static function strToOrderByFindAll($order = null){
			$str = '';
			if(is_array($order)&&isset($order[0])){
				$column = $order[0];
				$sort = isset($order[1])&&$order[1] ? 'DESC' : 'ASC';
				$str = ' ORDER BY '.$column.' '.$sort;
			}
			return $str;
		}
		
		static function fetchAndGetObj($STH){
			$mw = [];
			while($obj = $STH->fetch()){
				$mw[] = $obj;
			}
			return $mw;
		}
		
		static function getStrLimit(array $limit = null){
			if(($limit!=null)&&(!empty($limit))){
				$str = ' LIMIT ';
				$str .= $limit[0];
				if(!empty($limit[1])){
					$str .= ', '.$limit[1];
				}
				return $str;
			}
			return '';
		}
		
		static public function strToWhere(array $param = []){
			if(!empty($param)){
				$st = ' WHERE ';
			}else{
				return '';
			}
			$sp = ' AND ';
			$res = [];
			foreach($param as $k=>$v){
				$res[] = $k.' = :'.$k;
			}
			return $st.implode($sp,$res);
		}
		
		static public function dataBindToExecute(array $param = []){
			$res = [];
			foreach($param as $k=>$v){
				$res[':'.$k] = $v;
			}
			return $res;
		}
		
		public function objectBindToExecute(){
			$key = [];
			foreach($this->getKeyNativeProp() as $v){
				$key[':'.$v] = $this->$v;
			}
			return $key;
		}
		
		public function objectStringToSet(){
			$key = [];
			$sp = ', ';
			foreach($this->getKeyNativeProp() as $v){
				$key[] = $v.' = :'.$v;
			}
			return implode($sp,$key);
		}
		
		public function objectStringToInsert($isNameOrValue = 'name'){
			$key = $this->getKeyNativeProp();
			if($isNameOrValue == 'name'){
				return implode(', ',$key);
			}
			if($isNameOrValue == 'value'){
				return ':'.implode(', :',$key);
			}
		}
		
		//Выбираем все свойства модели которые объявлены
		public function getKeyNativeProp(array $without_params = []){
			$k = [];
			$ref = new ReflectionClass(self::tableName());
			foreach($ref->getProperties() as $v){
				if($v->getDeclaringClass()->getName() !== get_class(new static())) continue;
				if(!empty($without_params)&&in_array($v->getName(),$without_params)) continue;
				$k[] = $v->getName();
			}
			return $k;
		}
	}