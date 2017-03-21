<?php
/**
* @class CustomerPayment
*
* This class defines the users in the administration system.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class CustomerPayment extends Db_Object {

	static public function costSubscription() {
		return '1.00';
	}

	static public function isActive($customer) {
		$item = CustomerPayment::readFirst(array('where'=>'idCustomer="'.$customer->id().'"
													AND payed="1"
													AND NOW() BETWEEN payDate 
													AND DATE_ADD(payDate, INTERVAL 1 YEAR)'));
		return ($item->id()!='') ? true : false;
	}

	public function paypal() {
		$options = array('item_name' => __('subscriptionFbApps'),
						'item_number' => 365 + $this->id(),
						'item_amount' => CustomerPayment::costSubscription(),
						'currency_code' => 'USD',
						'cancel_return' => url('pagos/cancelado'),
						'return' => url('pagos/pagado/'.md5('plasticwebs'.$this->id())));
		return PayPal::checkout($options);
	}

}
?>