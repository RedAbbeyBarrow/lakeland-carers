<?php

class Admin_Form_LoginForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		$this->setAttrib('id', 'loginFormID');
		
		$email = $this->createElement('text','email');
        $email->setLabel('E-mail: *')
        	  ->setRequired(true)
        	  ->addValidator(new Zend_Validate_EmailAddress())
              ->setAttrib('size',50);
        
        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
        			->setRequired(true)
        			->addValidator(new Zend_Validate_Alnum())
	                ->setAttrib('size',50);
        
        $submit = $this->createElement('submit','submit');
        $submit->setLabel("Login")
                ->setIgnore(true)
                ->setAttrib('class', 'btn add-btn');

        $this->addElements(array(
            		$email,
            		$password,
            		$submit
        ));
    }


}

