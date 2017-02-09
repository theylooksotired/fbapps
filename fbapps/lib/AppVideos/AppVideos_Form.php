<?php
/**
* @class AppVideosController
*
* This class manages the forms for the AppVideos objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppVideos_Form extends Form {

	public function createHtml() {
		$fields = '<div class="formHelp">'.__('videoMainHelp').'</div>
				'.$this->field('title').'
				'.$this->field('video').'
				<div class="videosExtra">
					<div class="formHelp">'.__('videoExtraHelp').'</div>
					<div class="formFields formFields2">
						'.$this->field('titleVideoExtra1').'
						'.$this->field('videoExtra1').'
					</div>
					<div class="formFields formFields2">
						'.$this->field('titleVideoExtra2').'
						'.$this->field('videoExtra2').'
					</div>
					<div class="formFields formFields2">
						'.$this->field('titleVideoExtra3').'
						'.$this->field('videoExtra3').'
					</div>
					<div class="formFields formFields2">
						'.$this->field('titleVideoExtra4').'
						'.$this->field('videoExtra4').'
					</div>
				</div>';
		return Form::createForm($fields, array('submit'=>__('save'), 'class'=>'formPublic'));
	}

}
?>