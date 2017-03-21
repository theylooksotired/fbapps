<?php
/**
* @class CustomerLogin
*
* This class manages the login Customer objects.
* It is a singleton, so it can only be instantiated one object using a function.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Customer_Login {
    
    /**
    * Singleton pattern.
    * To instantiate this object we use the getInstance() static function.
    */
    protected static $login = null;
    protected $info;

    private function __construct() {
        $this->info = Session::get('infoCustomer');
        $this->info = ($this->info=='') ? array() : $this->info;
    }
    
    private function __clone() {}

    public static function getInstance() {
        if (null === self::$login) {
            self::$login = new self();
        }
        return self::$login;
    }
    
    /**
    * Get the id of the logged customer.
    */
    public function id() {
        return $this->get('idCustomer');
    }

    /**
    * Universal getter.
    */
    public function get($value) {
        return (isset($this->info[$value])) ? $this->info[$value] : '';
    }

    /**
    * Get the customer.
    */
    public function customer() {
        if (isset($this->customer)) {
            return $this->customer;
        }
        $this->customer = Customer::read($this->id());
        return $this->customer;
    }
    
    /**
    * Update the session array.
    */
    private function sessionAdjust($info=array()) {
        Session::set('infoCustomer', $info);
    }

    /**
    * Check if the customer is connected.
    */
    public function isConnected() {
        return (isset($this->info['idCustomer']) && $this->info['idCustomer']!='') ? true : false;
    }
    
    /**
    * Check the customer login using it's email and password.
    * If so, it saves the customer values in the session.
    */
    public function checklogin($options) {
        $values = array();
        $values['email'] = (isset($options['email'])) ? $options['email'] : '';
        $values['password'] = (isset($options['password'])) ? $options['password'] : '';
        $values['md5password'] = md5($values['password']);
        if ($values['email']!='' && ($values['password']!='' || $values['passwordTemp']!='')) {            
            $customer = Customer::readFirst(array('where'=>'email=:email AND (password=:md5password OR passwordTemp=:password) AND active="1"'), $values);
            if ($customer->id()!='') {
                $this->autoLogin($customer);
                $this->sessionAdjust($this->info);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    * Automatically login a customer.
    */
    public function autoLogin($customer) {
        $this->info['idCustomer'] = $customer->id();
        $this->info['email'] = $customer->get('email');
        $this->info['label'] = $customer->getBasicInfo();
        $this->sessionAdjust($this->info);
    }

    /**
    * Eliminate session values and logout a customer.
    */
    public function logout() {
        $this->info = array();
        $this->sessionAdjust();
    }

}
?>