<?php
/**
* @class AppVideosUi
*
* This class manages the UI for the AppVideos objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class AppVideos_Ui extends Ui{

	public function renderSection() {
		$video1 = ($this->object->get('videoExtra1')!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra1').'" href="'.Url::format($this->object->get('videoExtra1')).'" target="_blank">'.VideoLink::videoImage($this->object->get('videoExtra1')).'</a></div>' : '';
		$video2 = ($this->object->get('videoExtra2')!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra2').'" href="'.Url::format($this->object->get('videoExtra2')).'" target="_blank">'.VideoLink::videoImage($this->object->get('videoExtra2')).'</a></div>' : '';
		$video3 = ($this->object->get('videoExtra3')!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra3').'" href="'.Url::format($this->object->get('videoExtra3')).'" target="_blank">'.VideoLink::videoImage($this->object->get('videoExtra3')).'</a></div>' : '';
		$video4 = ($this->object->get('videoExtra4')!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra4').'" href="'.Url::format($this->object->get('videoExtra4')).'" target="_blank">'.VideoLink::videoImage($this->object->get('videoExtra4')).'</a></div>' : '';
        return VideoLink::renderPlayer($this->object->get('video'), array('width'=>'100%', 'height'=>'400px')).'
        		<div class="imageAppVideos">
        			'.$video1.'
        			'.$video2.'
        			'.$video3.'
        			'.$video4.'
        		</div>';
    }

}

?>