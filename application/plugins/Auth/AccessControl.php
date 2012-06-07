<?php
class Application_Plugin_Auth_AccessControl extends Zend_Controller_Plugin_Abstract
{
	private $_auth;
	private $_acl;
       
	public function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = new Application_Plugin_Auth_Acl();
	}
	
	public function routeStartup(Zend_Controller_Request_Abstract $request)
	{
		$request->setParam("module", $request->getModuleName());
		$request->setParam("controller", $request->getControllerName());
		$request->setParam("action", $request->getActionName());
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if ($this->_auth->hasIdentity() && is_object($this->_auth->getIdentity())) {
			$role = $this->_auth->getIdentity()->role;
		} else {
			$role = "guests";
		}
		
		$module = $request->getModuleName();
        $resource = $request->getControllerName();
        $action = $request->getActionName();

        if (!$this->_acl->isAllowed($role, $module.":".$resource, $action)) {
			if ($this->_auth->hasIdentity()) {
                $request->setModuleName($module);
                $request->setControllerName('error');
                $request->setActionName('noaccess');
			} else {
				$request->setModuleName('admin');
                $request->setControllerName('security');
                $request->setActionName('login');
			}
		} 
        $this->setRequest($request);
    }
}