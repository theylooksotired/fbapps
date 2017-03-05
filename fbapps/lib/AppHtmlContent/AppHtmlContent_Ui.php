<?php
/**
* @class AppHtmlContentUi
*
* This class manages the UI for the AppHtmlContent objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppHtmlContent_Ui extends Ui{

	public function renderFrame() {
        return '<div class="pageComplete">'.$this->object->get('content').'</div>';
    }

}

?>