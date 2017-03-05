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
        if ($this->action=='cuenta') {
            $this->layoutPage = 'account';
            switch ($this->id) {
                case 'conectarse':
                    $this->titlePage = __('login');
                    if (count($this->values)>0) {
                        $login = Customer_Login::getInstance();
                        $login->checklogin($this->values);
                        if ($login->isConnected()) {
                            header('Location: '.url('cuenta/'));
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
                case 'conectarse-facebook':
                    try {
                        $fb = Navigation_Controller::getFacebookObject();
                        $helper = $fb->getRedirectLoginHelper();
                        $oAuth2Client = $fb->getOAuth2Client();
                        $accessToken = $helper->getAccessToken();
                        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
                        $customerId = $tokenMetadata->getUserId();
                        $customer = Customer::readFirst(array('where'=>'facebookId="'.$customerId.'"'));
                        if ($customer->id()=='') {
                            $customer = new Customer();
                            $info = $fb->get('/me?fields=id,name,email', $accessToken);
                            $body = $info->getDecodedBody();
                            $values = array('facebookId'=>$body['id'],
                                            'name'=>$body['name'],
                                            'email'=>$body['email'],
                                            'password'=>substr(md5(rand()*rand()), 0, 6),
                                            'active'=>'1');
                            $customer->insert($values);
                        }
                        $login = Customer_Login::getInstance();
                        $login->autoLogin($customer);
                        header('Location: '.url('cuenta/mi-cuenta'));
                    } catch(PDOException $error){
                        if (DEBUG) {
                            throw new Exception('<pre>'.$error->getMessage().'</pre>');
                        } else {
                            header('Location: '.url('cuenta/crear-cuenta'));
                        }
                    }
                    exit();
                break;
                case 'crear-cuenta':
                    $this->titlePage = __('createAccount');
                    if (count($this->values)>0) {
                        $form = new Customer_Form($this->values);
                        $errors = $form->isValid();
                        if (count($errors) > 0) {
                            $form = new Customer_Form($this->values, $errors);
                        } else {
                            $this->values['active'] = 1;
                            $customer = new Customer();
                            $customer->insert($this->values);
                            $login = Customer_Login::getInstance();
                            $login->autoLogin($customer);
                            HtmlMail::send($customer->get('email'), 'welcome');
                            header('Location: '.url('cuenta/mi-cuenta'));
                            exit();
                        }
                    } else {                
                        $form = new Customer_Form();
                    }
                    $this->content = $form->createAccount();
                    return $this->ui->render();
                break;
                case 'salir':
                    $login = Customer_Login::getInstance();
                    $login->logout();
                    header('Location: '.url(''));
                break;
                case 'olvide-password':
                    $this->titlePage = __('passwordForgot');
                    $form = new Customer_Form();
                    if (isset($this->values['email'])) {
                        $customer = Customer::readFirst(array('where'=>'email="'.$this->values['email'].'" AND active="1"'));
                        if ($customer->id()!='') {
                            $tempPassword = substr(md5(rand()*rand()), 0, 10);
                            $customer->modifySimple('passwordTemp', $tempPassword);
                            $updatePasswordLink = url('cuenta/conectarse');
                            HtmlMail::send($customer->get('email'), 'passwordForgot', array('TEMP_PASSWORD'=>$tempPassword, 'UPDATE_PASSWORD_LINK'=>$updatePasswordLink));
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
                    $this->titlePage = __('myAccount');
                    $customer = $this->login->customer();
                    $this->content = $customer->showUi('Payments');
                    return $this->ui->render();
                break;
                case 'aplicaciones-instaladas':
                    $this->login = Customer::login();
                    $this->titlePage = __('installedApplications');
                    $customer = $this->login->customer();
                    $this->content = $customer->showUi('InstalledApplications');
                    return $this->ui->render();
                break;
                case 'pagos':
                    $this->login = Customer::login();
                    $this->titlePage = __('payments');
                    $customer = $this->login->customer();
                    $this->content = 'dsadas';
                    return $this->ui->render();
                break;
                case 'informacion-personal':
                    $this->login = Customer::login();
                    $this->titlePage = __('personalInformation');
                    $form = Customer_Form::newObject($this->login->customer());
                    if (count($this->values) > 0) {
                        $this->values['idCustomer'] = $this->login->id();
                        $form = new Customer_Form($this->values);
                        $errors = $form->isValidMyInformation($this->values);
                        if (count($errors) > 0) {
                            $this->messageError = __('errorsForm');
                        } else {
                            $this->login->customer()->modify($this->values, array('complete'=>false));
                            $this->message = __('savedForm');
                        }
                        header('Location: '.url($this->action.'/'.$this->id));
                        exit();
                    } else {
                        $this->content = $form->myAccount();
                    }
                    return $this->ui->render();
                break;
                case 'cambiar-password':
                    $this->login = Customer::login();
                    $this->titlePage = __('changePassword');
                    $form = Customer_Form::newObject($this->login->customer());
                    if (count($this->values) > 0) {
                        $this->values['idCustomer'] = $this->login->id();
                        $form = new Customer_Form($this->values);
                        $errors = $form->isValidChangePassword($this->login->customer());
                        if (count($errors) > 0) {
                            $this->messageError = __('changePasswordError');
                        } else {
                            $this->login->customer()->modify($this->values, array('complete'=>false));
                            $this->login->customer()->modifySimple('passwordTemp', '');
                            $this->message = __('changePasswordSuccess');
                        }
                        header('Location: '.url($this->action.'/'.$this->id));
                        exit();
                    } else {
                        $this->content = $form->changePassword();
                    }
                    return $this->ui->render();
                break;
                case 'pagar-suscripcion':
                    $this->login = Customer::login();
                    $this->titlePage = __('paySubscription');
                    $this->content = 'dasdas';
                    return $this->ui->render();
                break;
            }
        }
        return parent::controlActions();
    }    
}
?>