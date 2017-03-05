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

	static public function isActive($customer) {
		$item = CustomerPayment::readFirst(array('where'=>'idCustomer="'.$customer->id().'" AND NOW() BETWEEN payDate AND DATE_ADD(payDate, INTERVAL 1 YEAR)'));
		return ($item->id()!='') ? true : false;

	}

}
?>