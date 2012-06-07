<?php

class Admin_Form_News extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id', 'newsForm');
		
		$title = $this->createElement('text','title');
        $title->setLabel('Article Title:*')
        	 	  ->setRequired(true)
        	 	  ->addValidator(new Zend_Validate_StringLength(array('max' => 100)))
        	 	  ->setAttrib('class', 'article-title');
        
        $image = new Zend_Form_Element_File('image');
		$image->setLabel('Article Image:')
				->setValueDisabled(true)
				->setIgnore(true)
				->addValidator('Extension', false, 'jpg,png');
				
        $article = $this->createElement('textarea','article_content');
        $article->setLabel('Article:*')
					  ->setRequired(true)
					  ->setAttrib('rows', '6')
					  ->setAttrib('class', 'ckeditor');
    	
    	$submit = $this->createElement('submit','submit');
        $submit->setLabel("Submit")
                ->setIgnore(true)
                ->setAttrib('class', 'btn add-btn');

        $this->addElements(array(
        			$title,
        			$image,
            		$article,
            		$submit
        ));
    }


}

