<?php

class ClientsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function testimonialsAction()
    {
        $page = $this->getRequest()->getParam('page', 1);
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
	 	$select = $dbAdapter->select()->from('testimonials')
	 								  ->order('date_added DESC');
       	$paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage(5);
	 	$paginator->setCurrentPageNumber($page);
	 	$this->view->paginator = $paginator;
    }


}



