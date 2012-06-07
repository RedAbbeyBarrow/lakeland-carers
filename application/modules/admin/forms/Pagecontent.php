<?php

class Admin_Form_Pagecontent extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id', 'updatePagesForm');
		
		$content = $this->createElement('textarea','content');
        $content->setLabel('Content:*')
					  ->setRequired(true)
					  ->setAttrib('id', 'content')
    				  ->setAttrib('rows', '6')
    				  ->setAttrib('class', 'ckeditor');
        
        $submit = $this->createElement('submit','submit');
        $submit->setLabel("Update")
                ->setIgnore(true)
                ->setAttrib('class', 'btn add-btn');

        $this->addElements(array(
            		$content,
            		$submit
        ));
    }


}

