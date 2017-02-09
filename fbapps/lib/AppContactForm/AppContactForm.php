<?php
/**
* @class AppContactForm
*
* This class represents a category for contact forms.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppContactForm extends Db_Object {

	public function secret() {
		return md5('plasticwebs-contact-'.$this->id());
	}

	static public function readSecret($md5) {
		return AppContactForm::readFirst(array('where'=>'MD5(CONCAT("plasticwebs-contact-",idAppContactForm))="'.$md5.'"'));
	}

}
?>