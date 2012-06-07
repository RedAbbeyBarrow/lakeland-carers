<?php
class Admin_TestimonialsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . "/javascript/admin/confirm.js","text/javascript");
		
		$testimonials_table = new Admin_Model_Db_Table_Testimonials();
		$testimonials = $testimonials_table->fetchAll($testimonials_table->select());
		$testimonials = $testimonials->toArray();
		$this->view->testimonials = $testimonials;
    }

    public function addAction()
    {
    	$this->view->javaScript()->initJQueryValidate();
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . "/javascript/admin/testimonial.js","text/javascript");
		
        $testimonial_form = new Admin_Form_Testimonial();
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($testimonial_form->isValid($formData)) {
				$formData = $testimonial_form->getValues();
				$formData['date_added'] = date('Y-m-d H:i:s');
				$formData['last_update'] = date('Y-m-d H:i:s');
				
				$testimonials_table = new Admin_Model_Db_Table_Testimonials();
				$testimonials_table->insert($formData);
				$this->_redirect('/admin/testimonials/');
			}
		}
		$this->view->testimonial_form = $testimonial_form;
    }

    public function updateAction()
    {
        
        $this->view->javaScript()->initJQueryValidate();
    	$this->view->headScript()->appendFile($this->getRequest()->getBaseURL() . "/javascript/admin/testimonial.js","text/javascript");
        
        $testimonial_id = $this->getRequest()->getParam('testimonial');
        $testimonials_table = new Admin_Model_Db_Table_Testimonials();
		$testimonial = $testimonials_table->fetchRow($testimonials_table->select()->where('id = ?', $testimonial_id));
		$testimonial = $testimonial->toArray();
		$this->view->testimonial = $testimonial;
		
		$testimonial_form = new Admin_Form_Testimonial();
		$testimonial_form->populate($testimonial);
		if ($this->getRequest()->isPost()) {
			$formData  = $this->_request->getPost();
			if ($testimonial_form->isValid($formData)) {
				$formData = $testimonial_form->getValues();
				$formData['last_update'] = date('Y-m-d H:i:s');
				$where = array();
				$where[] = $testimonials_table->getAdapter()->quoteInto('id = ?', $testimonial_id);
				$testimonials_table->update($formData, $where);
				$this->_redirect('/admin/testimonials/');
			}
		}

		$this->view->testimonial_form = $testimonial_form;
    }

    public function deleteAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$testimonial_id = $this->getRequest()->getParam('testimonial');
		$testimonials_table = new Admin_Model_Db_Table_Testimonials();
	
		if (isset($testimonial_id)) {
			$where = array();
			$where[] = $testimonials_table->getAdapter()->quoteInto('id = ?', $testimonial_id);
			$testimonials_table->delete($where);
		}
		$this->_redirect('/admin/testimonials');      
    }


}







