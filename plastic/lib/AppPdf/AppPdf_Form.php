<?php
/**
* @class AppPdfController
*
* This class manages the forms for the AppPdf objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppPdf_Form extends Form {

	public function createHtml() {
		$fields = $this->field('title').'
				'.$this->field('pdf');
		return Form::createForm($fields, array('submit'=>__('save'), 'class'=>'formPublic'));
	}

}
?>