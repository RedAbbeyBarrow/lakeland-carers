<?php

class Admin_PagesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$pages_table = new Admin_Model_Db_Table_Pages();
		$pages = $pages_table->fetchAll($pages_table->select());
		$pages = $pages->toArray();
		$this->view->pages = $pages;		
    }

    public function updatecontentAction()
    {
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . '/javascript/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . '/javascript/admin/updatepagecontent.js');
		
        $page_id = $this->getRequest()->getParam('page_id');
        $pages_table = new Admin_Model_Db_Table_Pages();
		$page = $pages_table->fetchRow($pages_table->select()->where('id = ?', $page_id));
		$page = $page->toArray();
		$this->view->page = $page;
		$page['content'] = stripslashes($page['content']);
		
		$page_form = new Admin_Form_Pagecontent();
		$page_form->populate($page);
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($page_form->isValid($formData)) {
				$formData = $page_form->getValues();
				$formData['last_update'] = date('Y-m-d H:i:s');
				$where = array();
				$where[] = $pages_table->getAdapter()->quoteInto('id = ?', $page_id);
				$pages_table->update($formData, $where);
				$this->_redirect('/admin/pages');
			}
		}
		$this->view->page_form = $page_form;
    }

    public function updateseoAction()
    {
    	$this->view->javaScript()->initJQueryValidate();
        $this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . '/javascript/admin/pageseo.js');
		
        $page_id = $this->getRequest()->getParam('page_id');
        $pages_table = new Admin_Model_Db_Table_Pages();
		$page = $pages_table->fetchRow($pages_table->select()->where('id = ?', $page_id));
		$page = $page->toArray();
		$this->view->page = $page;
				
		$page_form = new Admin_Form_Page();
		$page_form->populate($page);
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($page_form->isValid($formData)) {
				$formData = $page_form->getValues();
				$formData['last_update'] = date('Y-m-d H:i:s');
				$where = array();
				$where[] = $pages_table->getAdapter()->quoteInto('id = ?', $page_id);
				$pages_table->update($formData, $where);
				$this->_redirect('/admin/pages');
			}
		}
		$this->view->page_form = $page_form;

    }


}



