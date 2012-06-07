<?php

class Admin_Form_Page extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id', 'pageForm');
		
		$title = $this->createElement('text','title');
        $title->setLabel('Page Title:*')
        	 	  ->setRequired(true)
        	 	  ->addValidator('stringLength', true, array(0, 70))
        	   	  ->setAttrib('size',50);
						  
		$meta_keywords = $this->createElement('textarea','meta_keywords');
        $meta_keywords->setLabel('Meta Keywords:*')
					  ->setRequired(true)
					  ->addValidator('stringLength', true, array(0, 250))
					  ->addFilter('StripTags')
					  ->setAttrib('cols', '38')
    				  ->setAttrib('rows', '2');
		
		$meta_description = $this->createElement('textarea','meta_description');
        $meta_description->setLabel('Meta Description:*')
					  ->setRequired(true)
					  ->addValidator('stringLength', true, array(0, 200))
					  ->addFilter('StripTags')
					  ->setAttrib('cols', '38')
    				  ->setAttrib('rows', '2');
    	
    	$submit = $this->createElement('submit','submit');
        $submit->setLabel("Update SEO")
                ->setIgnore(true)
                ->setAttrib('class', 'btn add-btn');

        $this->addElements(array(
        			$title,
            		$meta_keywords,
            		$meta_description,
            		$submit
        ));
    }


}

