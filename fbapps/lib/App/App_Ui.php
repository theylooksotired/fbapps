<?php
class App_Ui extends Ui{

	protected $object;

	public function __construct (App & $object) {
		$this->object = $object;
	}

	public function renderPublic() {
		return '<div class="app">
					<div class="appIns">
						<a href="'.$this->object->url().'">
							<div class="appImage" style="background-image:url('.$this->object->getImageUrl('image', 'web').');"></div>
							<div class="appText">
								<h3>'.$this->object->getBasicInfo().'</h3>
								<p>'.$this->object->get('shortDescription').'</p>
							</div>
						</a>
					</div>
				</div>';
	}

	public function renderComplete() {
		$next = urlencode(url('instalar-aplicacion/'.$this->object->id()));
		$login = Customer_Login::getInstance();
		if ($login->isConnected()) {
			if (CustomerPayment::isActive($login->customer())) {
				$link = '<a href="http://www.facebook.com/dialog/pagetab?app_id='.$this->object->get('appId').'&next='.$next.'" class="btnBig">'.__('installApp').'</a>';
            } else {
                $link = Customer_Ui::payFirstSubscription();
            }
		} else {
			$link = '<a href="'.url('cuenta/crear-cuenta').'" class="btnBig">'.__('createAccount').'</a>';
		}
		return '<div class="appComplete">
					<div class="appCompleteLeft">
						'.$this->object->getImage('image', 'web').'
					</div>
					<div class="appCompleteRight">
						<p><strong>'.$this->object->get('shortDescription').'</strong></p>
						'.Text::decodeText($this->object->get('description')).'
					</div>
				</div>
				<div class="appCompleteButton">
					'.$link.'
				</div>
				<div class="accountAppsExtra">
                    <h1>'.__('apps').'</h1>
                    <div class="accountAppsIns">
                        '.App_Ui::apps().'
                    </div>
                </div>';
	}

	static public function apps() {
		$items = new ListObjects('App', array('order'=>'ord'));
		return '<div class="apps">
					'.$items->showList().'
				</div>';
	}
	
}

?>