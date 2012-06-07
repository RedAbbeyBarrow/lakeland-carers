<?php

class Admin_Form_Testimonial extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id', 'testimonialForm');
		
		$from_company = $this->createElement('text','from_company');
        $from_company->setLabel('Company:*')
        	 	  ->setRequired(true)
        	 	  ->addValidator(new Zend_Validate_Alnum(array('allowWhiteSpace' => true)))
        	   	  ->setAttrib('size',50);
        
        $from_company_website = $this->createElement('text','from_company_website');
        $from_company_website->setLabel('Company Website:*')
        	 	  ->setRequired(true);
						  
		$testimonial_author = $this->createElement('text','testimonial_author');
        $testimonial_author->setLabel('Testimonial Author:*')
					  ->setRequired(true);
		
		$testimonial = $this->createElement('textarea','testimonial');
        $testimonial->setLabel('Testimonial:*')
					  ->setRequired(true)
					  ->setAttrib('rows', '6');
    	
    	$submit = $this->createElement('submit','submit');
        $submit->setLabel("Submit")
                ->setIgnore(true)
                ->setAttrib('class', 'btn add-btn');

        $this->addElements(array(
        			//$from_company,
        			//$from_company_website,
            		$testimonial_author,
            		$testimonial,
            		$submit
        ));
    }


}

