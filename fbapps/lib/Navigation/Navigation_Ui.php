<?php
class Navigation_Ui extends Ui {

	public function render() {
		$layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
		$title = (isset($this->object->titlePage)) ? '<h1>'.$this->object->titlePage.'</h1>' : '';
		$message = (isset($this->object->message)) ? '<div class="message">'.$this->object->message.'</div>' : '';
		$messageError = (isset($this->object->messageError)) ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
		$menuInside = (isset($this->object->menuInside)) ? $this->object->menuInside : '';
		$content = (isset($this->object->content)) ? $this->object->content : '';
		$contentExtra = (isset($this->object->contentExtra)) ? $this->object->contentExtra : '';
		$idInside = (isset($this->object->idInside)) ? $this->object->idInside : '';
		switch ($layoutPage) {
			default:
				return $this->header().'
						<div class="contentFormat">
							<div class="contentFormatIns">
								'.$title.'
								<div class="content">
									'.$content.'
								</div>
							</div>
						</div>
						'.$this->footer();
			break;
		}
	}

	public function header() {
		return '<header class="header">
			        <div class="headerLeft">
				    	<div class="logo">
				    		<a href="'.url('').'">'.Params::param('titlePage').'</a>
				    	</div>
			        </div>
			        <div class="headerRight">
						'.HtmlSection::show('header').'
					</div>
				</header>';
	}

	public function shareIcons() {
		return '<div class="shareIcons">
	        		<div class="shareIcon shareIconFacebook">
	        			<a href="'.Params::param('linksocial-facebook').'" target="_blank">Facebook</a>
	        		</div>
	        		<div class="shareIcon shareIconTwitter">
	        			<a href="'.Params::param('linksocial-twitter').'" target="_blank">Twitter</a>
	        		</div>
	        	</div>';
	}

	public function footer() {
		return '<footer class="footer">
					'.HtmlSection::show('footer').'
				</footer>';
	}

}
?>