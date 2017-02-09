<?php
class App extends Db_Object {

	public function linkApp() {
		if ($this->get('active')=='1') {
			return 'http://www.facebook.com/dialog/pagetab?app_id='.$this->get('appId').'&next='.urlencode($this->get('appUrl'));
			return 'http://www.facebook.com/dialog/pagetab?app_id='.$this->get('appId');
		}
	}

}
?>