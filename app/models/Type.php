<?php 
	class Type extends Eloquent{

		public function products(){
			return $this->hasMany('Product');
		}
	}

 ?>