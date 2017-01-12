<?php
class Navigation_Controller extends Controller{

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
		$this->ui = new Navigation_Ui($this);
	}
	
	public function controlActions(){
		switch ($this->action) {
			default:
			case 'error':
				header("HTTP/1.1 301 Moved Permanently"); 
				header('Location: '.url(''));
				exit();
			break;
			case 'intro':
				$this->content = 'dasdas';
				return $this->ui->render();
			break;
			case 'contact':
				$this->titlePage = __('contact');
				$this->layoutPage = 'clean';
				$client = Client::readFirst(array('where'=>'code="'.$this->id.'"'));
				if (count($this->values) > 0) {
					$form = new Contact_Form($this->values);
					$errors = $form->isValid();
					if (count($errors) > 0) {
						$form = new Contact_Form($this->values, $errors);
						$formHtml = $form->createPublic($client);
					} else {					
						$contact = new Contact();
						$contact->insert($this->values);
						HtmlMail::send($client->get('emailContact'), 'fbContact', array('CONTENT'=>$contact->showUi('Mail')));
						$formHtml = '<div class="message">'.$client->get('messageThanks').'</div>';
					}
				} else {					
					$form = new Contact_Form();
					$formHtml = $form->createPublic($client);
				}
				$this->content = $client->showUi('Public', array('formHtml'=>$formHtml));
				return $this->ui->render();
			break;
		}
	}
}
?>