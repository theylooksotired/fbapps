<?php
/**
* @class CustomerUi
*
* This class manages the UI for the Customer objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Customer_Ui extends Ui{
    
    static public function infoHtml() {
        $login = Customer_Login::getInstance();
        if ($login->isConnected()) {        
            $html = '<div class="infoCustomerItem infoCustomerMyAccount">
                        <a href="'.url('mi-cuenta').'">'.__('myAccount').'</a>
                    </div>
                    <div class="infoCustomerItem infoCustomerLogout">
                        <a href="'.url('salir').'">'.__('logout').'</a>
                    </div>';
        } else {
            $html = '<div class="infoCustomerItem infoCustomerLogin">
                        <a href="'.url('conectarse').'">'.__('login').'</a>
                    </div>
                    <div class="infoCustomerItem infoCustomerCreate">
                        <a href="'.url('crear-cuenta').'">'.__('createAccount').'</a>
                    </div>';
        }
        return '<div class="infoCustomer">'.$html.'</div>';
    }

}

?>