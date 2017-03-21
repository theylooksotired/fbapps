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

	public function renderFrame() {
        $imageVideo1 = VideoLink::videoImage($this->object->get('videoExtra1'));
        $imageVideo2 = VideoLink::videoImage($this->object->get('videoExtra2'));
        $imageVideo3 = VideoLink::videoImage($this->object->get('videoExtra3'));
        $imageVideo4 = VideoLink::videoImage($this->object->get('videoExtra4'));
        $video1 = ($imageVideo1!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra1').'" href="'.Url::format($this->object->get('videoExtra1')).'" target="_blank">'.$imageVideo1.'</a></div>' : '';
        $video2 = ($imageVideo2!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra2').'" href="'.Url::format($this->object->get('videoExtra2')).'" target="_blank">'.$imageVideo2.'</a></div>' : '';
        $video3 = ($imageVideo3!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra3').'" href="'.Url::format($this->object->get('videoExtra3')).'" target="_blank">'.$imageVideo3.'</a></div>' : '';
        $video4 = ($imageVideo4!='') ? '<div class="imageVideo"><a title="'.$this->object->get('titleVideoExtra4').'" href="'.Url::format($this->object->get('videoExtra4')).'" target="_blank">'.$imageVideo4.'</a></div>' : '';
        return VideoLink::renderPlayer($this->object->get('video'), array('width'=>'100%', 'height'=>'400px')).'
        		<div class="imageVideos">
        			'.$video1.'
        			'.$video2.'
        			'.$video3.'
        			'.$video4.'
        		</div>';
    }

}

?>