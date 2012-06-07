<?php
class Application_Plugin_View_SetView extends Zend_Controller_Plugin_Abstract {
	
	protected $_layout;
	protected $_view;
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		
		$this->setLayout();
		$this->setView();
		
		if ($request->getModuleName() == 'admin') {
			$this->setGlobalLayout();
			$this->setAdminCSS();
			$this->setJavascript();
		} else {
			$this->setGlobalLayout();
			$this->setDefaultCSS();
			$this->setJavascript();
		}
	}
	
	private function setLayout() {
		$this->_layout = Zend_Layout::getMvcInstance();
	}
	
	private function setView() {
		$this->_view = $this->_layout->getView();
	}
	
	private function setGlobalLayout() {
		$this->_view->doctype('XHTML1_STRICT');
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $this->_view->headTitle()->setSeparator(' - ');
        $this->_view->headTitle('Lakeland Carers');
	}
	
	private function setDefaultCSS() {
		$this->_view->headLink()->prependStylesheet($this->getRequest()->getBaseUrl() . "/css/screen.css");
	}
	
	private function setAdminCSS() {
		$this->_view->headLink()->appendStylesheet($this->getRequest()->getBaseUrl() . "/css/admin/style.css");
		$this->_view->headLink()->appendStylesheet($this->getRequest()->getBaseUrl() . "/css/admin/style_buttons.css");
		$this->_view->headLink()->appendStylesheet($this->getRequest()->getBaseUrl() . "/css/admin/style_form.css");
	}
	
	private function setJavascript() {
		$this->_view->javaScript()->initJQuery();
    	$this->_view->javaScript()->initJQueryUI();
    	$this->_view->javaScript()->initJQueryThemeRollerCSS();
    	$this->_view->javaScript()->initJQueryNivo();
	}
}