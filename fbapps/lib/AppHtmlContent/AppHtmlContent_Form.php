<?php
/**
* @class AppHtmlContentController
*
* This class manages the forms for the AppHtmlContent objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppHtmlContent_Form extends Form {

	public function createHtml() {
		$fields = $this->field('title').'
				'.FormField::create('textarea', array('name'=>'content', 'id'=>'content', 'value'=>$this->values['content'], 'error'=>$this->errors['content']));
		return Form::createForm($fields, array('submit'=>__('save'), 'class'=>'formPublic')).'
				<script>
					CKEDITOR.replace(\'content\');
				</script>';
	}

}
?>