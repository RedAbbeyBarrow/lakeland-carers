<?php
class Application_Plugin_Cms_SetCms extends Zend_Controller_Plugin_Abstract {
	
	protected $_layout;
	protected $_view;
	private $_identifier;
	private $_page_title;
	private $_meta_keywords;
	private $_meta_description;
	private $_content;
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		
		$this->setLayout();
		$this->setView();
		
		if ($request->getModuleName() != 'admin') {
			$this->buildIdentifier($request);
			$this->setPageData();
			$this->setCMSData();
		}
	}
	
	private function setLayout() {
		$this->_layout = Zend_Layout::getMvcInstance();
	}
	
	private function setView() {
		$this->_view = $this->_layout->getView();
	}
	
	private function buildIdentifier($request)
    {
    	$this->_identifier = $request->getModuleName().":".
					  		 $request->getControllerName().":".
					  		 $request->getActionName();
    }
    
    private function setPageData()
    {
    	$pages_table = new Default_Model_Db_Table_Pages();
		$page_data = $pages_table->fetchRow($pages_table->select()->where('identifier = ?', $this->_identifier));	
		
		if (count($page_data) <= 0) {
			$this->_pageTitle = "";
			$this->_meta_keywords = "";
			$this->_meta_description = "";
			$this->_content = "";
		} else {
			$this->_pageTitle = $page_data['title'];
			$this->_meta_keywords = $page_data['meta_keywords'];
			$this->_meta_description = $page_data['meta_description'];
			$this->_content = stripslashes($page_data['content']);
		}
    }
    
    public function getPageTitle()
    {
    	return $this->_view->headTitle($this->_pageTitle);
    }
    
    public function getMetaKeywords()
    {
    	return $this->_view->headMeta()->appendName('keywords', $this->_meta_keywords)." ". $this->_view->headMeta()->appendName('description', $this->_meta_description);
    }
    
    public function getContent()
    {
    	return $this->_content;
    }
    
	private function setCMSData(){
		$this->getPageTitle();
		$this->getMetaKeywords();
		$this->_view->content = $this->getContent();
	}
}