<?php

class Admin_Model_Db_Table_News extends Zend_Db_Table_Abstract
{

	protected $_name = 'news';
	protected $_primary = 'id';
	protected $_sequence = true; // needed if i have a PK that auto incremements
	
}

