<?php
class Navigation_Ui extends Ui {

	public function render() {
		$layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
		$title = (isset($this->object->titlePage)) ? '<h1>'.$this->object->titlePage.'</h1>' : '';
		$linkMobile = (isset($this->object->linkMobile)) ? '<div class="linkMobile">'.__('linkMobilePublic').' : <a href="'.$this->object->linkMobile.'" target="_blank">'.$this->object->linkMobile.'</a></div>' : '';
		$message = (isset($this->object->message) && $this->object->message!='') ? '<div class="message">'.$this->object->message.'</div>' : '';
		$messageError = (isset($this->object->messageError) && $this->object->messageError!='') ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
		$menuInside = (isset($this->object->menuInside)) ? $this->object->menuInside : '';
		$content = (isset($this->object->content)) ? $this->object->content : '';
		$contentExtra = (isset($this->object->contentExtra)) ? $this->object->contentExtra : '';
		$idInside = (isset($this->object->idInside)) ? $this->object->idInside : '';
		switch ($layoutPage) {
			default:
				return '<div class="bodySite">
							'.$this->header().'
							<div class="contentFormat">
								<div class="contentFormatIns">
									<div class="content">
										'.$title.'
										'.$message.'
										'.$messageError.'
										'.$linkMobile.'
										'.$content.'
									</div>
								</div>
							</div>
							'.$this->footer().'
						</div>';
			break;
			case 'intro':
				return '<div class="bodySite bodySiteIntro">
							'.$this->header().'
							<div class="contentFormat">
								'.$content.'
							</div>
							'.$this->footer().'
						</div>';
			break;
			case 'account':
				$login = Customer_Login::getInstance();
				if ($login->isConnected()) {
					$contentHtml = '<div class="contentLeft">
										'.Customer_Ui::sidebar().'
									</div>
									<div class="contentRight">
										'.$title.'
										'.$message.'
										'.$messageError.'
										'.$content.'
									</div>';
				} else {
					$contentHtml = $title.'
								'.$message.'
								'.$messageError.'
								'.$content;
				}
				return '<div class="bodySite">
							'.$this->header().'
							<div class="contentFormat contentFormatAccount">
								<div class="contentFormatIns">
									<div class="content">
										'.$contentHtml.'
									</div>
								</div>
							</div>
							'.$this->footer().'
						</div>';
			break;
			case 'clean':
				return $content;
			break;
		}
	}

	public function header() {
		$layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
		return '<div class="header">
					<div class="headerIns">
						<div class="headerLeft">
							<div class="logo">
								<a href="'.url().'">'.$this->object->getTitle().'</a>
							</div>
							'.$this->menu().'
						</div>
						<div class="headerRight">
							'.Customer_Ui::infoHtml().'
						</div>
					</div>
				</div>';
	}

	public function shareIcons() {
		return '<div class="shareIcons">
					<div class="shareIcon shareIconFacebook">
						<a href="'.Url::format(Params::param('facebook')).'" target="_blank">Facebook</a>
					</div>
					<div class="shareIcon shareIconTwitter">
						<a href="'.Url::format(Params::param('twitter')).'" target="_blank">Twitter</a>
					</div>
				</div>';
	}

	public function footer() {
		return '<div class="footer">
					'.Page::show('footer').'
				</div>';
	}

	public function menu() {
		return '<div class="menu">
					<div class="menuItem"><a href="'.url('aplicaciones').'">'.__('applications').'</a></div>
					<div class="menuItem"><a href="'.url('como-instalar').'">'.__('howToInstall').'</a></div>
					<div class="menuItem"><a href="'.url('costo').'">'.__('cost').'</a></div>
				</div>';
	}

}
?>