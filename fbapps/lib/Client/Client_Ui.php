<?php
/**
* @class ClientUi
*
* This class manages the UI for the Client objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Client_Ui extends Ui{

	public function renderPublic($options=array()) {
		$formHtml = (isset($options['formHtml'])) ? $options['formHtml'] : '';
		$imageUrl = $this->object->getFileUrl('imageLogo');
		$titleImage = ($imageUrl!='') ? '<img src="'.$imageUrl.'" alt="'.$this->object->getBasicInfo().'"/>' : $this->object->getBasicInfo();
		$title = ($this->object->get('linkWeb')!='') ? '<a href="'.$this->object->get('linkWeb').'" target="_blank">'.$titleImage.'</a>' : $titleImage;
		$backgroundImage = $this->object->getFileUrl('imageBackground');
		$backgroundImage = ($backgroundImage!='') ? ' style="background-image:url('.$backgroundImage.');"' : '';
		$titleMessage = ($this->object->get('titleMessage')!='') ? '<h1>'.$this->object->get('titleMessage').'</h1>' : '';
		return '<div class="contact contact-'.$this->object->get('code').'" '.$backgroundImage.'>
					<div class="contactWrapper">
						<header>
							<div class="headerIns">
								<div class="logo">'.$title.'</div>
								<div class="headerInfo">'.$this->object->get('header').'</div>
							</div>
						</header>
						<section>
							'.$titleMessage.'
							'.$formHtml.'
						</section>
						<footer>
							<div class="footerIns">'.$this->object->get('footer').'</div>
						</footer>
					</div>
				</div>';
	}

}
?>