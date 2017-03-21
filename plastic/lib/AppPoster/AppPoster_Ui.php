<?php
/**
* @class AppPosterUi
*
* This class manages the UI for the AppPoster objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppPoster_Ui extends Ui{

	public function renderFrame() {
        return '<div class="imageAppPoster">
        			'.$this->object->getImage('poster', 'huge').'
        		</div>';
    }

}

?>