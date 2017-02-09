<?php
/**
* @class CustomerPageLogin
*
* This class manages the login CustomerPage objects.
* It is a singleton, so it can only be instantiated one object using a function.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class CustomerPage_Login {
    
    /**
    * Singleton pattern.
    * To instantiate this object we use the getInstance() static function.
    */
    protected static $login = null;
    protected $info;

    private function __construct() {
        $this->info = Session::get('infoCustomerPage');
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
    * Get the id of the logged user.
    */
    public function id() {
        return $this->get('idCustomerPage');
    }

    /**
    * Universal getter.
    */
    public function get($value) {
        return (isset($this->info[$value])) ? $this->info[$value] : '';
    }

    /**
    * Get the user.
    */
    public function user() {
        if (isset($this->user)) {
            return $this->user;
        }
        $this->user = CustomerPage::read($this->id());
        return $this->user;
    }
    
    /**
    * Update the session array.
    */
    private function sessionAdjust($info=array()) {
        Session::set('infoCustomerPage', $info);
    }

    /**
    * Check if the user is connected.
    */
    public function isConnected() {
        return (isset($this->info['idCustomerPage']) && $this->info['idCustomerPage']!='') ? true : false;
    }
    
    /**
    * Check the user login using it's email and password.
    * If so, it saves the user values in the session.
    */
    public function checklogin($options) {
        $values = array();
        $values['email'] = (isset($options['email'])) ? $options['email'] : '';
        $values['password'] = (isset($options['password'])) ? $options['password'] : '';
        $values['md5password'] = md5($values['password']);
        if ($values['email']!='' && ($values['password']!='' || $values['passwordTemp']!='')) {            
            $user = CustomerPage::readFirst(array('where'=>'email=:email AND (password=:md5password OR passwordTemp=:password) AND active="1"'), $values);
            if ($user->id()!='') {
                $this->autoLogin($user);
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
    * Automatically login a user.
    */
    public function autoLogin($user) {
        $type = CustomerPageType::read($user->get('idCustomerPageType'));
        $this->info['idCustomerPage'] = $user->id();
        $this->info['email'] = $user->get('email');
        $this->info['label'] = $user->getBasicInfo();
        $this->info['code'] = $type->get('code');
        $this->info['idCustomerPageType'] = $type->id();
        $this->sessionAdjust($this->info);
    }

    /**
    * Eliminate session values and logout a user.
    */
    public function logout() {
        $this->info = array();
        $this->sessionAdjust();
    }

}
?>