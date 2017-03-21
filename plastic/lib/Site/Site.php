<?php
class Site extends Db_Object {

	public function __construct($values=array()) {
		parent::__construct($values);
	}
	
	public function getBasicInfo() {
		return $this->get('title');
	}

}
?>