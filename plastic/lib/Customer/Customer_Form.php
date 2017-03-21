<?php
/**
* @class CustomerForm
*
* This class manages the forms for the Customer objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Customer_Form extends Form{

    public function login() {
        $fields = $this->field('email').'
                    '.$this->field('password');
        return '<div class="simpleForm">
                    <div class="message">'.__('loginMessage').'</div>
                    '.Form::createForm($fields, array('action'=>url('cuenta/conectarse'), 'class'=>'formAdmin', 'submit'=>__('send'))).'
                    '.$this->loginFacebookButton().'
                    <div class="options"><a href="'.url('cuenta/olvide-password').'">'.__('passwordForgot').'</a></div>
                </div>';
    }

    public function forgot() {
        $fields = $this->field('email');
        return '<div class="simpleForm">
                    <div class="message">'.__('passwordForgotMessage').'</div>
                    '.Form::createForm($fields, array('action'=>url('cuenta/olvide-password'), 'class'=>'formAdmin', 'submit'=>__('send'))).'
                    <div class="options"><a href="'.url('cuenta/conectarse').'">'.__('tryLoginAgain').'</a></div>
                </div>';
    }

    public function forgotSent() {
        return '<div class="simpleForm">
                    <div class="message">'.__('passwordSentMail').'</div>
                    <div class="options"><a href="'.url('cuenta/conectarse').'">'.__('tryLoginAgain').'</a></div>
                </div>';
    }

    public function updatePassword() {
        $fields = $this->field('email').'
                '.FormField_Password::create(array('label'=>__('password'), 'name'=>'password', 'error'=>$this->errors['oldPassword'], 'value'=>''));
        return '<div class="simpleForm">
                    <div class="message">'.__('passwordTempMessage').'</div>
                    '.Form::createForm($fields, array('action'=>url('cuenta/actualizar-password'), 'class'=>'formAdmin', 'submit'=>__('send'))).'
                </div>';
    }

    public function changePassword() {
        $this->errors['oldPassword'] = isset($this->errors['oldPassword']) ? $this->errors['oldPassword'] : '';
        $fields = FormField_Password::create(array('label'=>__('oldPassword'), 'name'=>'oldPassword', 'error'=>$this->errors['oldPassword'], 'value'=>'')).'
                '.FormField_Password::create(array('label'=>__('password'), 'name'=>'password', 'error'=>$this->errors['oldPassword'], 'value'=>''));
        return '<div class="simpleForm">
                    <div class="message">'.__('changePasswordMessage').'</div>
                    '.Form::createForm($fields, array('action'=>url('cuenta/mi-cuenta-password'), 'class'=>'formAdmin', 'submit'=>__('save'))).'
                </div>';
    }

    public function isValidChangePassword($user) {
        $errors = array();
        if (!isset($this->values['oldPassword']) || trim($this->values['oldPassword'])=='') {
            $errors['oldPassword'] = __('oldPasswordError');
        } else {        
            if ($user->get('passwordTemp')!='' && $this->values['oldPassword']!=$user->get('passwordTemp')) {
                $errors['oldPassword'] = __('oldPasswordError');
            }
        }
        $errors = array_merge($errors, $this->isValidField($this->object->attributeInfo('password')));
        return $errors;
    }

    public function createAccount() {
        $fields = $this->field('name').'
                '.$this->field('lastName').'
                '.$this->field('email').'
                '.$this->field('password');
        return '<div class="simpleForm">
                    <div class="message">'.__('createAccountMessage').'</div>
                    '.Form::createForm($fields, array('action'=>url('cuenta/crear-cuenta'), 'class'=>'formAdmin', 'submit'=>__('createAccount'))).'
                    '.$this->loginFacebookButton().'
                </div>';
    }

    public function myAccount() {
        $fields = $this->field('email').'
                '.$this->field('name').'
                '.$this->field('lastName').'
                '.$this->field('nit').'
                '.$this->field('telephone').'
                '.$this->field('address');
        return '<div class="simpleForm">
                    <div class="message">'.__('myAccountMessage').'</div>
                    '.Form::createForm($fields, array('action'=>url('cuenta/informacion-personal'), 'class'=>'formAdmin', 'submit'=>__('save'))).'
                </div>';
    }

    public function isValidMyInformation() {
        $errors = array();
        $items = array('email', 'name');
        foreach ($items as $item) {
            $error = $this->isValidField($this->object->attributeInfo($item));
            if (count($error)>0) {
                $errors = array_merge($error, $errors);
            }            
        }
        return $errors;
    }

    public function loginFacebookButton() {
        $fb = Navigation_Controller::getFacebookObject();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $loginUrl = $helper->getLoginUrl(url('cuenta/conectarse-facebook'), $permissions);
        return '<div class="facebookLogin">
                        <a href="' . htmlspecialchars($loginUrl) . '">'.__('loginWithFacebook').'</a>
                    </div>';
    }
    
}
?>