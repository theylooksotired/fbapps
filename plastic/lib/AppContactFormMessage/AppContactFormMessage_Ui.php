<?php
/**
* @class AppContactFormMessageUi
*
* This class manages the UI for the AppContactFormMessage objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppContactFormMessage_Ui extends Ui{
	
	public function renderMail() {
		$info = '';
		$info .= ($this->object->get('name')!='') ? '<strong>'.__('name').' :</strong> '.Text::recodeText($this->object->get('name')).'<br/>' : '';
		$info .= ($this->object->get('lastName')!='') ? '<strong>'.__('lastName').' :</strong> '.Text::recodeText($this->object->get('lastName')).'<br/>' : '';
		$info .= ($this->object->get('email')!='') ? '<strong>'.__('email').' :</strong> '.Text::recodeText($this->object->get('email')).'<br/>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<strong>'.__('telephone').' :</strong> '.Text::recodeText($this->object->get('telephone')).'<br/>' : '';
		$info .= ($this->object->get('typeMessage')!='') ? '<strong>'.__('typeMessage').' :</strong> '.Text::recodeText($this->object->get('typeMessage')).'<br/>' : '';
		$info .= ($this->object->get('message')!='') ? '<strong>'.__('message').' :</strong> '.nl2br(Text::recodeText($this->object->get('message'))).'<br/>' : '';
		return '<p>'.$info.'</p>';
	}

}
?>