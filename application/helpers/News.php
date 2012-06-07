<?php
class My_View_Helper_News extends Zend_View_Helper_Abstract {
	
	public $_view;
	private $_article_id;
	private $_article_title;
	private $_article_thumbnail;
	
	public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    
	public function News()
    {	
		return $this;
    }  
    
    public function getRandom() {
    	$news_table = new Default_Model_Db_Table_News();
    	$page_data = $news_table->fetchRow($news_table->select()->order('date_added DESC'));	
    	
    	$this->_article_id = $page_data['id'];
    	$this->_article_title = $page_data['title'];
    	$this->_article_thumbnail = $page_data['thumbnail_image_url'];
    }
    
    public function getArticleID() {
    	return $this->_article_id;
    }
    
    public function getArticleTitle() {
    	return $this->_article_title;
    }
    
    public function getArticleThumbnail() {
    	return $this->_article_thumbnail;
    }
    
}
?>