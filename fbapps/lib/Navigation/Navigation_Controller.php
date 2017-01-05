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
		}
	}
}
?>