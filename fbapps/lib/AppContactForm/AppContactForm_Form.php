<?php
/**
* @class AppContactFormForm
*
* This class manages the forms for the AppContactForm objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppContactForm_Form extends Form{

	public function createHtml() {
		$fields = '<h2>'.__('appInformation').'</h2>
					<div class="formFields formFields2">
						'.$this->field('linkWeb').'
						'.$this->field('emailContact').'
					</div>
					<h2>'.__('formInformation').'</h2>
					'.$this->field('titleMessage').'
					<div class="formFields formFields2">
						'.$this->field('header').'
						'.$this->field('footer').'
					</div>
					<div class="formFields formFields2">
						'.$this->field('typeMessage').'
						'.$this->field('messageThanks').'
					</div>
					<h2>'.__('style').'</h2>
					<div class="formFields formFields2">
						'.$this->field('imageLogo').'
						'.$this->field('imageBackground').'
					</div>
					<div class="formFields formFields3">
						'.$this->field('colorBackground').'
						'.$this->field('colorBackgroundHeader').'
						'.$this->field('colorBackgroundFooter').'
					</div>
					<div class="formFields formFields3">
						'.$this->field('colorText').'
						'.$this->field('colorTextHeader').'
						'.$this->field('colorTextFooter').'
					</div>';
		return Form::createForm($fields, array('submit'=>__('save'), 'class'=>'formPublic'));
	}

}
?>