<?php
/**
* @class CustomerController
*
* This class is the controller for the Customer objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Customer_Controller extends Controller {

    public function controlActions(){
        $this->ui = new Navigation_Ui($this);
        switch ($this->action) {
            case 'conectarse':
                $this->titlePage = __('login');
                if (count($this->values)>0) {
                    $login = Customer_Login::getInstance();
                    $login->checklogin($this->values);
                    if ($login->isConnected()) {
                        header('Location: '.url(''));
                    } else {
                        $form = new Customer_Form();
                        $this->messageError = __('errorConnection');
                        $this->content = $form->login();
                    }
                } else {                
                    $form = new Customer_Form();
                    $this->content = $form->login();
                }
                return $this->ui->render();
            break;
            case 'crear-cuenta':
                $this->titlePage = __('createAccount');
                if (count($this->values)>0) {
                } else {                
                    $form = new Customer_Form();
                    $this->content = $form->createAccount();
                }
                return $this->ui->render();
            break;
            case 'salir':
                $login = Customer_Login::getInstance();
                $login->logout();
                header('Location: '.url(''));
            break;
            case 'olvide-password':
                $this->mode = 'admin';
                $this->layoutPage = 'simple';
                $this->titlePage = __('passwordForgot');
                $form = new Customer_Form();
                if (isset($this->values['email'])) {
                    $user = Customer::readFirst(array('where'=>'email="'.$this->values['email'].'" AND active="1"'));
                    if ($user->id()!='') {
                        $tempPassword = substr(md5(rand()*rand()), 0, 10);
                        $user->modifySimple('passwordTemp', $tempPassword);
                        $updatePasswordLink = url('Customer/login', true);
                        HtmlMail::send($user->get('email'), 'passwordForgot', array('TEMP_PASSWORD'=>$tempPassword, 'UPDATE_PASSWORD_LINK'=>$updatePasswordLink));
                        $this->content = $form->forgotSent();
                    } else {
                        $this->messageError = __('mailDoesntExist');
                        $this->content = $form->forgot();
                    }
                } else {
                    $form = new Customer_Form();
                    $this->content = $form->forgot();
                }
                return $this->ui->render();
            break;
            case 'mi-cuenta':
                $this->login = Customer::login();
                $this->mode = 'admin';
                $this->titlePage = __('myAccount');
                $form = Customer_Form::newObject($this->login->user());
                $this->message = ($this->id == 'successPersonal') ? __('savedForm') : '';
                $this->message = ($this->id == 'successPassword') ? __('changePasswordSuccess') : $this->message;
                $this->messageError = ($this->id == 'errorPersonal') ? __('errorsForm') : '';
                $this->messageError = ($this->id == 'errorPassword') ? __('changePasswordError') : $this->messageError;
                $this->content = '<div class="myAccount">
                                        <div class="myAccountPersonal">
                                            '.$form->myAccount().'
                                        </div>
                                        <div class="myAccountPassword">
                                            '.$form->changePassword().'
                                        </div>
                                    </div>';
                return $this->ui->render();
            break;
            case 'mi-cuenta-informacion':
                $this->login = Customer::login();
                if (count($this->values) > 0) {
                    $this->values['idCustomer'] = $this->login->id();
                    $form = new Customer_Form($this->values);
                    $errors = $form->isValidMyInformation($this->values);
                    if (count($errors) > 0) {
                        header('Location: '.url('Customer/myAccount/errorPersonal', true));
                    } else {
                        $this->login->user()->modify($this->values, array('complete'=>false));
                        header('Location: '.url('Customer/myAccount/successPersonal', true));
                    }
                    exit();
                }
                header('Location: '.url('Customer/myAccount', true));
                exit();
            break;
            case 'mi-cuenta-password':
                $this->login = Customer::login();
                if (count($this->values) > 0) {
                    $this->values['idCustomer'] = $this->login->id();
                    $form = new Customer_Form($this->values);
                    $errors = $form->isValidChangePassword($this->login->user());
                    if (count($errors) > 0) {
                        header('Location: '.url('Customer/myAccount/errorPassword', true));
                    } else {
                        $this->login->user()->modify($this->values, array('complete'=>false));
                        $this->login->user()->modifySimple('passwordTemp', '');
                        header('Location: '.url('Customer/myAccount/successPassword', true));
                    }
                    exit();
                }
                header('Location: '.url('Customer/myAccount', true));
                exit();
            break;
        }
        return parent::controlActions();
    }    
}
?>