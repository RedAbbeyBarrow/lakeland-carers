<?php

class Admin_SecurityController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        $form = new Admin_Form_LoginForm();
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($form->isValid($formData)) {
				$formData = $form->getValues();
				
				$db = Zend_Db_Table::getDefaultAdapter();
				$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users','email', 'password', 'MD5(?)');
				$authAdapter->setIdentity($formData['email']);
				$authAdapter->setCredential($formData['password']);
				
				$auth_result = $authAdapter->authenticate();
				switch ($auth_result->getCode()) {
					case Zend_Auth_Result::SUCCESS :               
						$auth = Zend_Auth::getInstance();
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(null, 'password'));
						$this->_redirect('/admin/');
						break;
					case Zend_Auth_Result::FAILURE :
						$this->view->login_errormsg = "Unknown Error." . nl2br(print_r($auth_result->getMessages(), true));
						break;
					case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS :
						$this->view->login_errormsg = "Email ambigous.";
						break;
					case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
						$this->view->login_errormsg = "Email not found.";
					case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
						$this->view->login_errormsg = "Email and/or password invalid.";
						break;
					case Zend_Auth_Result::FAILURE_UNCATEGORIZED :
						$this->view->login_errormsg = "Uncategorized error.<br>" . nl2br(print_r($auth_result->getMessages(), true));
						break;
					default :
						$this->view->login_errormsg = "Unknown error." . nl2br(print_r($auth_result->getMessages(), true));
						break;
				}
			}
		}
    }

    public function logoutAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect("/");
    }


}





