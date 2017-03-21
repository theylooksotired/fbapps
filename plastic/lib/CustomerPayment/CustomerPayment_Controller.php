<?php
/**
* @class CustomerPaymentController
*
* This class is the controller for the CustomerPayment objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class CustomerPayment_Controller extends Controller {
	
	public function controlActions(){
        $this->ui = new Navigation_Ui($this);
        if ($this->action=='pagos') {
            $this->layoutPage = 'account';
            switch ($this->id) {
                default:
                    $customer = Customer::loggedCustomer();
                    $this->titlePage = __('payments');
                    $this->content = $customer->showUi('Payments');
                    return $this->ui->render();
                break;
                case 'cancelado':
                    $customer = Customer::loggedCustomer();
                    $this->titlePage = __('payments');
                    $this->messageError = __('paymentCancelMessage');
                    $this->content = Customer_Ui::payFirstSubscription();
                    return $this->ui->render();
                break;
                case 'pagado':
                    $customer = Customer::loggedCustomer();
                    $this->titlePage = __('payments');
                    $this->message = __('paymentSuccessMessage');
                    $customerPayment = CustomerPayment::readFirst(array('where'=>'MD5(CONCAT("plasticwebs",idCustomerPayment))="'.$this->extraId.'"'));
                    if ($customerPayment->id()!='') {
                        $customerPayment->modify(array('payed'=>'1',
                                                        'payDate'=>date("Y-m-d H:i:s"),
                                                        'amount'=>CustomerPayment::costSubscription())
                                                    );
                    }
                    $this->content = App_Ui::apps();
                    return $this->ui->render();
                break;
            }
        }
        return parent::controlActions();
    }   
}
?>