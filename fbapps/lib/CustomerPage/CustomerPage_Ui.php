<?php
/**
* @class CustomerPageUi
*
* This class manages the UI for the CustomerPage objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class CustomerPage_Ui extends Ui{
    
    public function renderPublic() {
    	$link = 'https://www.facebook.com/'.$this->object->get('pageId');
    	$title = ($this->object->get('name')!='') ? $this->object->get('name').' <span>'.$link.'</span>' : $link;
    	return '<div class="fbPage">
    				<a href="'.$link.'" target="_blank">
    					'.$title.'
    				</a>
    			</div>';
    }

    public function renderInfo($options=array()) {
    	$app = $options['app'];
    	$link = 'https://www.facebook.com/'.$this->object->get('pageId');
    	$linkMobile = url('aplicacion-movil/'.$app->get('code').'/'.$this->object->get('pageId'));
    	$title = ($this->object->get('name')!='') ? $this->object->get('name').' <span>('.$link.')</span>' : $link;
    	return '<div class="fbPageInfo">
					<p><strong>'.__('page').' : </strong> <a href="'.$link.'" target="'.$link.'">'.$title.'</a></p>
					<p><strong>'.__('linkMobile').' : </strong> <a href="'.$linkMobile.'">'.$linkMobile.'</a></p>
    			</div>';
    }

}
?>