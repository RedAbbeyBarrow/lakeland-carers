<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page', 1);
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
	 	$select = $dbAdapter->select()->from('news')
	 								  ->order('date_added DESC');
       	$paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage(5);
	 	$paginator->setCurrentPageNumber($page);
	 	$this->view->paginator = $paginator;
    }

    public function viewAction()
    {
        $article_id = $this->getRequest()->getParam('article');
        $article_table = new Default_Model_Db_Table_News();
		$article = $article_table->fetchRow($article_table->select()->where('id = ?', $article_id));
		$article = $article->toArray();
		$this->view->article = $article;
    }


}



