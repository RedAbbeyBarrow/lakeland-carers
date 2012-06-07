<?php
class My_View_Helper_Testimonial extends Zend_View_Helper_Abstract {
	
	public $_view;
	private $_testimonial;
	private $_testimonial_author;
	
	public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    
	public function Testimonial()
    {
    	return $this;
    }  
    
    public function getRandom() {
    	$testimonial_table = new Default_Model_Db_Table_Testimonials();
    	$page_data = $testimonial_table->fetchRow($testimonial_table->select()->order('rand()'));	
    	
    	$this->_testimonial = $page_data['testimonial'];
    	$this->_testimonial_author = $page_data['testimonial_author'];
    }
    
    public function getTestimonial() {
    	return $this->_testimonial;
    }
    
    public function getTestimonialAuthor() {
    	return $this->_testimonial_author;	
    }	
    
}
?>