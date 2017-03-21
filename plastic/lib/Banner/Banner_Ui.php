<?php
class Banner_Ui extends Ui{

	protected $object;

	public function __construct (Banner & $object) {
		$this->object = $object;
	}

	public function renderPublic() {
		return '<div class="banner">
					<div class="bannerIns">
						<div class="bannerImage" style="background-image:url('.$this->object->getImageUrl('image', 'huge').');"></div>
						<div class="bannerText">
							'.html_entity_decode($this->object->get('content')).'
						</div>
					</div>
				</div>';
	}
	
}

?>