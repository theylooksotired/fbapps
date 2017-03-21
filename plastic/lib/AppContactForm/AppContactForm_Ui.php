<?php
/**
* @class AppContactFormUi
*
* This class manages the UI for the AppContactForm objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppContactForm_Ui extends Ui{

	public function renderFrame() {
		$imageUrl = $this->object->getFileUrl('imageLogo');
		$titleImage = ($imageUrl!='') ? '<img src="'.$imageUrl.'" alt="'.$this->object->getBasicInfo().'"/>' : $this->object->getBasicInfo();
		$title = ($this->getValue('linkWeb')!='') ? '<a href="'.Url::format($this->getValue('linkWeb')).'" target="_blank">'.$titleImage.'</a>' : $titleImage;
		$titleMessage = ($this->getValue('titleMessage')!='') ? '<h1>'.$this->getValue('titleMessage').'</h1>' : '';
		$form = new AppContactFormMessage_Form();
		return $this->renderContactStyle().'
				<div class="contact contact-'.$this->getValue('code').'">
					<div class="contactWrapper">
						<header>
							<div class="headerIns">
								<div class="logo">'.$title.'</div>
								<div class="headerInfo">'.nl2br($this->getValue('header')).'</div>
							</div>
						</header>
						<section>
							'.$titleMessage.'
							'.$form->createPublic($this->object).'
						</section>
						<footer>
							<div class="footerIns">'.nl2br($this->getValue('footer')).'</div>
						</footer>
					</div>
				</div>';
	}

	public function renderContactStyle() {
		$backgroundImage = $this->object->getFileUrl('imageBackground');
		$backgroundImage = ($backgroundImage!='') ? ' background-image:url('.$backgroundImage.');' : '';
		return '<style>
					.contact {
						background-color:'.$this->getValue('colorBackground').';
						color:'.$this->getValue('colorText').';
						'.$backgroundImage.';
					}
					.contact header {
						background-color:'.$this->getValue('colorBackgroundHeader').';
						color:'.$this->getValue('colorTextHeader').';
					}
					.contact footer {
						background-color:'.$this->getValue('colorBackgroundFooter').';
						color:'.$this->getValue('colorTextFooter').';
					}
					.contact section h1 {
						color: '.$this->getValue('colorBackground').';
						border-bottom: 5px solid '.$this->getValue('colorBackgroundHeader').';
					}
					.contact section .formContact .formField label {
						color: '.$this->getValue('colorBackground').';
					}
					.contact section .formContact .formField input,
					.contact section .formContact .formField select,
					.contact section .formContact .formField textarea {
						color: '.$this->getValue('colorText').';
					}
					.contact section .formContact input.formSubmit {
						background-color:'.$this->getValue('colorBackgroundFooter').';
						color:'.$this->getValue('colorTextFooter').';
					}
					.contact .message {
						background-color:'.$this->getValue('colorBackgroundHeader').';
						color:'.$this->getValue('colorTextHeader').';
					}
				</style>';
	}

	public function getValue($attribute) {
		$value = $this->object->get($attribute);
		if ($value!='') {
			return $value;
		} elseif ($this->object->get('name')=='') {
			switch ($attribute) {
				case 'name': return 'Formulario de contacto'; break;
				case 'linkWeb': return 'www.plasticwebs.com'; break;
				case 'titleMessage': return 'Escribenos utilizando el siguiente formulario'; break;
				case 'emailContact': return 'info@plasticwebs.com'; break;
				case 'messageThanks': return 'Gracias por contactarse con nosotros'; break;
				case 'header': return 'El siguiente formulario es un producto de Plasticwebs'; break;
				case 'footer': return 'Plastic Webs, empresa dedicada al diseño web en Bolivia'; break;
				case 'colorBackground': return '#00ab83'; break;
				case 'colorBackgroundHeader': return '#cbe67c'; break;
				case 'colorBackgroundFooter': return '#00664e'; break;
				case 'colorText': return '#333'; break;
				case 'colorTextHeader': return '#003d2f'; break;
				case 'colorTextFooter': return '#ffffff'; break;
			}
		}
	}


}
?>