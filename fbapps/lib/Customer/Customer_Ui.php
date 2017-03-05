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
                        <a href="'.url('cuenta/mi-cuenta').'">'.__('myAccount').'</a>
                    </div>
                    <div class="infoCustomerItem infoCustomerLogout">
                        <a href="'.url('cuenta/salir').'">'.__('logout').'</a>
                    </div>';
        } else {
            $html = '<div class="infoCustomerItem infoCustomerLogin">
                        <a href="'.url('cuenta/conectarse').'">'.__('login').'</a>
                    </div>
                    <div class="infoCustomerItem infoCustomerCreate">
                        <a href="'.url('cuenta/crear-cuenta').'">'.__('createAccount').'</a>
                    </div>';
        }
        return '<div class="infoCustomer">'.$html.'</div>';
    }

    static public function sidebar() {
        return '<div class="sidebarMenu">
                    <div class="sidebarMenuItem">
                        <a href="'.url('cuenta/mi-cuenta').'">'.__('myAccount').'</a>
                    </div>
                    <div class="sidebarMenuItem">
                        <a href="'.url('cuenta/aplicaciones-instaladas').'">'.__('installedApplications').'</a>
                    </div>
                    <div class="sidebarMenuItem">
                        <a href="'.url('cuenta/pagos').'">'.__('payments').'</a>
                    </div>
                    <div class="sidebarMenuItem sidebarMenuItemPersonal">
                        <a href="'.url('cuenta/informacion-personal').'">'.__('personalInformation').'</a>
                    </div>
                    <div class="sidebarMenuItem sidebarMenuItemPersonal">
                        <a href="'.url('cuenta/cambiar-password').'">'.__('changeMyPassword').'</a>
                    </div>
                    <div class="sidebarMenuItem sidebarMenuItemLogout">
                        <a href="'.url('cuenta/salir').'">'.__('logout').'</a>
                    </div>
                </div>';
    }

    public function renderInstalledApplications() {
        $content  = '';
        $items = CustomerPage::readList(array('where'=>'idCustomer="'.$this->object->id().'"'));
        if (count($items) > 0) {
            $apps = App::readList(array('order'=>'ord'));
            foreach ($items as $item) {
                $contentInsApps = '';
                foreach ($apps as $app) {
                    $objectAppName = $app->get('objectName');
                    $objectApp = new $objectAppName();
                    $objectApp = $objectApp->readFirstObject(array('where'=>'pageId="'.$item->get('pageId').'"'));
                    if ($objectApp->id()!='') {
                        $contentInsApps .= '<div class="accountPageApp">
                                                <div class="accountPageAppTitle">'.$app->getBasicInfo().'</div>
                                                <div class="accountPageAppOptions">
                                                    <a href="'.url('aplicacion-configuracion/'.$app->get('code').'/'.md5('plasticwebs'.$item->id())).'">'.__('configure').'</a>
                                                </div>
                                            </div>';
                    }
                }
                $itemsIns = new ListObjects('CustomerPage', array('where'=>'idCustomer="'.$this->object->id().'"'));
                $contentInsApps = ($contentInsApps=='') ? '<div class="message">'.__('noInstalledApplications').'</div>' : $contentInsApps;
                $content .= '<div class="accountApp">
                                '.$item->showUi('Public').'
                                '.$contentInsApps.'
                            </div>';
            }
        } else {
            $content = '<div class="message">'.__('noInstalledApplications').'</div>';
        }
        return $content.'
                <div class="accountAppsExtra">
                    <h1>'.__('apps').'</h1>
                    <div class="accountAppsIns">
                        '.App_Ui::apps().'
                    </div>
                </div>';
    }

    public function renderPayments() {
        $items = CustomerPayment::readList(array('order'=>'payDate DESC'));
        if (count($items) > 0) {
            $lastPayment = $items[0];
        } else {
            return Customer_Ui::payFirstSubscription();
        }
    }

    static public function payFirstSubscription() {
        return '<div class="messagePayment">
                    '.Page::show('payFirstSubscriptionMessage').'
                    <p><a href="'.url('cuenta/pagar-suscripcion').'" class="btnBig">'.__('paySubscription').'</a></p>
                </div>';
    }

}

?>