<?php
/**
* @class CustomerPaymentUi
*
* This class manages the UI for the CustomerPayment objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class CustomerPayment_Ui extends Ui{

	public function renderPublic() {
		return '<div class="payment">
					<div class="paymentLeft">
						<h2>'.__('subscriptionFbApps').'</h2>
						<p>'.Date::sqlText($this->object->get('payDate'), true).'</p>
					</div>
					<div class="paymentRight">
						<div class="money">'.$this->object->get('amount').' <span>USD</span></div>
					</div>
				</div>';
	}

}
?>