<?php
class Application_Plugin_Layout_SetLayout extends Zend_Controller_Plugin_Abstract {
	
	protected $_moduleLayouts;
	protected $_layout;
	protected $_view;
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		
		$this->setLayout();
		$this->setView();
		$this->setModuleLayoutArray();
		$this->determineCorrectLayout($request->getModuleName());
	}
	
	private function setLayout() {
		$this->_layout = Zend_Layout::getMvcInstance();
	}
	
	private function setView() {
		$this->_view = $this->_layout->getView();
	}
	
	public function setModuleLayoutArray () {
		$this->_moduleLayouts['default'] = array('layoutPath' => APPLICATION_PATH . '/modules/default/layouts/','layout' => 'layout');
		$this->_moduleLayouts['admin'] = array('layoutPath' => APPLICATION_PATH . '/modules/admin/layouts/','layout' => 'layout');
	}
	
	private function determineCorrectLayout($module_name) {
		if(isset($this->_moduleLayouts[$module_name])){
			$config = $this->_moduleLayouts[$module_name];
			
			if($this->_layout->getMvcEnabled()){
				$this->_layout->setLayoutPath($config['layoutPath']);
				
				if($config['layout'] !== null){
					$this->_layout->setLayout($config['layout']);
				}
			}
		}
	}
}