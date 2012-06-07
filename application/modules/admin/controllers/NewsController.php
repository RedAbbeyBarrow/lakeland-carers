<?php

class Admin_NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . "/javascript/admin/confirm.js","text/javascript");
		
		$news_table = new Admin_Model_Db_Table_News();
		$news = $news_table->fetchAll($news_table->select());
		$news = $news->toArray();
		$this->view->news = $news;
    }

    public function addAction()
    {
        $this->view->javaScript()->initJQueryValidate();
        $this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . '/javascript/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . "/javascript/admin/news.js","text/javascript");
		
        $news_form = new Admin_Form_News();
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($news_form->isValid($formData)) {
				$formData = $news_form->getValues();
				$formData['date_added'] = date('Y-m-d H:i:s');
				$formData['last_update'] = date('Y-m-d H:i:s');
				
				$news_table = new Admin_Model_Db_Table_News();
				$news_table->insert($formData);
				
				$adapter = $news_form->image->getTransferAdapter();
				$last_id = $news_table->getAdapter()->lastInsertId();
				$news_image_model = new Admin_Model_NewsImage($adapter, $last_id);
				
				$image_url_data['article_image_url'] = $news_image_model->get_article_image_url();
				$image_url_data['thumbnail_image_url'] = $news_image_model->get_thumbnail_image_url();
				$where = array();
				$where[] = $news_table->getAdapter()->quoteInto('id = ?', $last_id);
				$news_table->update($image_url_data, $where);
				
				/*
				$this->_redirect('/admin/news/');
				*/
			}
		}
		$this->view->news_form = $news_form;
    }

    public function updateAction()
    {
        $this->view->javaScript()->initJQueryValidate();
        $this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . '/javascript/ckeditor/ckeditor.js');
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . "/javascript/admin/news.js","text/javascript");
    	
        $article_id = $this->getRequest()->getParam('article');
		$news_table = new Admin_Model_Db_Table_News();
		$article = $news_table->fetchRow($news_table->select()->where('id = ?', $article_id));
		$article = $article->toArray();
		$this->view->article = $article;
		
		$news_form = new Admin_Form_News();
		$news_form->populate($article);
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($news_form->isValid($formData)) {
				$formData = $news_form->getValues();
				
				$adapter = $news_form->image->getTransferAdapter();
				if ($adapter->isUploaded()) {
					$news_image_model = new Admin_Model_NewsImage($adapter, $article_id);
					$formData['article_image_url'] = $news_image_model->get_article_image_url();
					$formData['thumbnail_image_url'] = $news_image_model->get_thumbnail_image_url();
				} 
				
				$formData['last_update'] = date('Y-m-d H:i:s');
				$where = array();
				$where[] = $news_table->getAdapter()->quoteInto('id = ?', $article_id);
				$news_table->update($formData, $where);
				$this->_redirect('/admin/news/');
			}
		}

		$this->view->news_form = $news_form;
    }

	public function deleteAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$article_id = $this->getRequest()->getParam('article');
		$news_table = new Admin_Model_Db_Table_News();
	
		if (isset($article_id)) {
			$where = array();
			$where[] = $news_table->getAdapter()->quoteInto('id = ?', $article_id);
			$news_table->delete($where);
		}
		$this->_redirect('/admin/news');     
    }

}