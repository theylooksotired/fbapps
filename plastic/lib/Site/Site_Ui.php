<?php
class Site_Ui extends Ui{

	protected $object;

	public function __construct (Site & $object) {
		$this->object = $object;
	}

	public function renderPublic() {
		return '<div class="site">
					<div class="siteIns">
						<div class="siteImage" style="background-image:url('.$this->object->getImageUrl('image', 'web').');"></div>
						<div class="siteText">
							<h3><a href="'.Url::format($this->object->get('link')).'" target="_blank">'.$this->object->getBasicInfo().'</a></h3>
							'.html_entity_decode($this->object->get('description')).'
						</div>
					</div>
				</div>';
	}
	
	static public function showList() {
		$items = new ListObjects('Site', array('order'=>'ord'));
		return '<div class="sites">'.$items->showList().'</div>';
	}

}

?>