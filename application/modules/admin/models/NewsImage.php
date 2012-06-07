<?php

class Admin_Model_NewsImage
{
	
	private $_adapter;
	private $_article_id;
	private $_image_destination_path;
	private $_mime_type;
	private $_origional_image_file;
	
	public function __construct($adapter, $article_id) 
	{
		$this->_adapter = $adapter;
		$this->_article_id = $article_id;
		$this->_image_destination_path = '/images/admin/news/'.$this->_article_id;
		$mime = explode('/', $this->_adapter->getMimeType());
		$this->_mime_type = $mime['1'];
	
		$this->create_new_article_folder();
		$this->save_origional_image();
		
		$this->save_resized_image(BASE_PATH.$this->_image_destination_path.'/news-article-'.$this->_article_id.'-article.'.$this->_mime_type, 600);
		$this->save_resized_image(BASE_PATH.$this->_image_destination_path.'/news-article-'.$this->_article_id.'-thumbnail.'.$this->_mime_type, 200);
	}
	
	private function create_new_article_folder()
	{
		if (!is_dir(BASE_PATH.$this->_image_destination_path)) {
			mkdir(BASE_PATH.$this->_image_destination_path, 0755);
		} 
	}
	
	private function save_origional_image() 
	{
		$this->_adapter->setDestination(BASE_PATH.$this->_image_destination_path);
		$this->_adapter->addFilter('Rename',array('target' => BASE_PATH.$this->_image_destination_path.'/news-article-'.$this->_article_id.'-origional.'.$this->_mime_type,'overwrite' => true));
		
		try {
			$this->_adapter->receive();
		} catch (Zend_File_Transfer_Exception $e) {
			$e->getMessage();
		}

		$this->_origional_image_file = $this->_adapter->getFileName();
	}
	
	private function get_origional_image_file()
	{
		return $this->_origional_image_file;
	}
	
	private function save_resized_image($file_location, $width)
	{	
		$resize_obj = new Admin_Model_ImageResize($this->get_origional_image_file());
 		$resize_obj->resizeImage($width, null, 'landscape');
   		$resize_obj->saveImage($file_location);
	}
	
	public function get_article_image_url()
	{
		return $this->_image_destination_path.'/news-article-'.$this->_article_id.'-article.'.$this->_mime_type;
	}
	
	public function get_thumbnail_image_url()
	{
		return $this->_image_destination_path.'/news-article-'.$this->_article_id.'-thumbnail.'.$this->_mime_type;
	}
	
}

