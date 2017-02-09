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
	public function createPublic($client) {
		$typeMessage = '';
		if ($client->get('typeMessage')!='') {
			$typeMessageValues = array();
			$typeMessageItems = explode(',', $client->get('typeMessage'));
			foreach ($typeMessageItems as $typeMessageItem) {
				$typeMessageValues[trim($typeMessageItem)] = trim($typeMessageItem);
			}
			$typeMessage = FormField::create('select', array('label'=>__('typeMessage'), 'value'=>$typeMessageValues, 'selected'=>$this->values['typeMessage']));
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
				'.$this->field('message');
		return $this->createForm($fields, array('submit'=>__('send'), 'class'=>'formAppContactFormMessage'));
	}

}
?>