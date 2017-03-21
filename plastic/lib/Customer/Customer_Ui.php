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
                        <a href="'.url('pagos').'">'.__('payments').'</a>
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

    public function renderInstalledApplicationsSimple() {
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
                                                <div class="accountPageAppTitle">
                                                    <p><strong>'.$app->getBasicInfo().'</strong></p>
                                                    <p><em>'.__('installedDate').' : '.Date::sqlText($objectApp->get('created'), true).'</em></p>
                                                </div>
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
        return $content;
    }

    public function renderInstalledApplications() {
        return $this->renderInstalledApplicationsSimple().'
                <div class="accountAppsExtra">
                    <h1>'.__('apps').'</h1>
                    <div class="accountAppsIns">
                        '.App_Ui::apps().'
                    </div>
                </div>';
    }

    public function renderPayments() {
        $items = new ListObjects('CustomerPayment', array('where'=>'payed="1"
                                                            AND idCustomer="'.$this->object->id().'"',
                                                            'order'=>'payDate DESC'));
        return Customer_Ui::payFirstSubscription().'
                <div class="payments">
                    '.$items->showList().'
                </div>';
    }


    static public function payFirstSubscription() {
        $login = Customer_Login::getInstance();
        if ($login->isConnected()) {
            $customer = Customer::read($login->id());
            if (!CustomerPayment::isActive($customer)) {
                $customerPayment = CustomerPayment::readFirst(array('where'=>'idCustomer="'.$customer->id().'" AND payed!="1"'));
                if ($customerPayment->id()=='') {
                    $customerPayment = new CustomerPayment();
                    $customerPayment->insert(array('idCustomer'=>$customer->id(), 'payed'=>'0'));
                }
                return '<div class="messagePayment">
                            '.Page::show('payFirstSubscriptionMessage').'
                            '.$customerPayment->paypal().'
                        </div>';
            }
        }
    }

}

?>