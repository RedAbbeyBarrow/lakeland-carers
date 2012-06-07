<?php

class Application_Plugin_Navigation_SetNavigation extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;
	protected $_role; 
	
	public function __construct()
	{
		$this->_acl = new Application_Plugin_Auth_Acl();
		$this->_role = (!Zend_Auth::getInstance()->hasIdentity()) ? "guests" : Zend_Auth::getInstance()->getIdentity()->role;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		$layout = Zend_Layout::getMvcInstance();
		$view = $layout->getView();
		$module = $request->getModuleName();
        if( $module == "admin" ){
			$navConfig = new Zend_Config_Xml(APPLICATION_PATH."/modules/admin/configs/admin_navigation.xml", 'nav');
		} else {
			$navConfig = new Zend_Config_Xml(APPLICATION_PATH."/modules/default/configs/navigation.xml", 'nav');
		}
		$navigation = new Zend_Navigation($navConfig);
		$view->navigation($navigation)->setAcl($this->_acl)->setRole($this->_role);
	}
    
}

