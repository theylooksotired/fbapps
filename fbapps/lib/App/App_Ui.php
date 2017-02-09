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
								<p>'.$this->object->get('description').'</p>
							</div>
						</a>
					</div>
				</div>';
	}

	public function renderComplete() {
		return '<div class="app">
					<div class="appIns">
						<div class="fbDialogButton"
							data-id="'.$this->object->get('appId').'"
							data-redirect="'.urlencode($this->object->get('appUrl')).'">
							<div class="appImage" style="background-image:url('.$this->object->getImageUrl('image', 'web').');"></div>
							<div class="appText">
								<h3>'.$this->object->getBasicInfo().'</h3>
								<p>'.$this->object->get('description').'</p>
							</div>
						</div>
					</div>
				</div>';
	}

	static public function intro() {
		$items = new ListObjects('App', array('order'=>'ord', 'limit'=>'9'));
		return '<div class="apps">
					'.$items->showList().'
				</div>';
	}
	
}

?>