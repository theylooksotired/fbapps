<?php
/**
* @class Customer
*
* This class defines the users in the administration system.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Customer extends Db_Object {

	/**
    * Check if a customer is connected
    */
	static public function login() {
        $login = Customer_Login::getInstance();
        if (!$login->isConnected()) {
            header('Location: '.url('cuenta/conectarse'));
            exit();
        }
        return $login;
	}

    /**
    * Get the logged user
    */
    static public function loggedCustomer() {
        $login = Customer::login();
        return Customer::read($login->id());
    }

}
?>