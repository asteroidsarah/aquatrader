<?php 
class Product extends Eloquent{
	//by extending Eloquent the mapping of model to database table will be done.

	public function type(){
		return $this->belongsTo('Type');
	}

	public function orders(){
		return $this->belongsToMany("Order");
	}

	protected $fillable = array('name','description','photo', 'price', 'type_id');
}

 ?>