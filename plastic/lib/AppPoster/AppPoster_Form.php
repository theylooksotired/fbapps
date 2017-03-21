<?php
/**
* @class AppPosterController
*
* This class manages the forms for the AppPoster objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppPoster_Form extends Form {

	public function createHtml() {
		$fields = $this->field('title').'
				'.$this->field('poster');
		return Form::createForm($fields, array('submit'=>__('save'), 'class'=>'formPublic'));
	}

}
?>