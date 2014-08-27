<?php 
class Order extends Eloquent{

	public function user(){
		return $this->belongsTo("User");
	}

	public function products(){
		return $this->belongsToMany("Product");
	}
}

?>
