<?php
/**
* @class AppContactFormMessageForm
*
* This class manages the forms for the AppContactFormMessage objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppContactFormMessage_Form extends Form{

	/**
	* Render the public form.
	*/
	public function createPublic($appContactForm) {
		$typeMessage = '';
		if ($appContactForm->get('typeMessage')!='') {
			$typeMessageValues = array();
			$typeMessageItems = explode(',', $appContactForm->get('typeMessage'));
			foreach ($typeMessageItems as $typeMessageItem) {
				$typeMessageValues[trim($typeMessageItem)] = trim($typeMessageItem);
			}
			$typeMessage = FormField::create('select', array('label'=>__('typeMessage'), 'name'=>'typeMessage', 'value'=>$typeMessageValues, 'selected'=>$this->values['typeMessage']));
		}
		$fields = '<div class="formFields formFields2">
						'.$this->field('name').'
						'.$this->field('lastName').'
					</div>
					<div class="formFields formFields2">
						'.$this->field('email').'
						'.$this->field('telephone').'
					</div>
					'.$typeMessage.'
					'.$this->field('message').'
					'.FormField::create('hidden', array('name'=>'code', 'value'=>$appContactForm->get('pageId')));
		return $this->createForm($fields, array('submit'=>__('send'), 'action'=>url('modal/contacto'), 'class'=>'formContact'));
	}

}
?>