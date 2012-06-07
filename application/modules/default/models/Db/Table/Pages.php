<?php

class Default_Model_Db_Table_Pages extends Zend_Db_Table_Abstract
{

	protected $_name = 'pages';
	protected $_primary = 'id';
	protected $_sequence = true; // needed if i have a PK that auto incremements
	
}

