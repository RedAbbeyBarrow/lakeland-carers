<?php
class My_View_Helper_JavaScript extends Zend_View_Helper_Abstract {
	
	public $_view;
	
	const JQUERY_PATH = 'javascript/jQuery/jquery-1.6.1.js';
	const JQUERY_UI_PATH = 'javascript/jQuery/jquery-ui-1.8.14.custom.min.js';
	const JQUERY_VALIDATE_PATH = 'javascript/jQuery/validate/jquery.validate.js';
	const JQUERY_VALIDATE_ADDITIONAL_METHODS_PATH = 'javascript/jQuery/validate/additional-methods.js';
	const JQUERY_NIVO_PATH = 'javascript/jQuery/nivo/jquery.nivo.js';
	const JQUERY_NIVO_INIT_PATH = 'javascript/jQuery/nivo/nivo.js';
	
	const JQUERY_THEMEROLLER_CSS = 'javascript/jQuery/css/bc-theme-1/jquery-ui-1.8.16.custom.css';
	
	public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    
	public function javaScript()
    {
       return $this;
    }   
    
    public function initJQuery()
    {
     	$resourceUrl = $this->buildResourceUrl(self::JQUERY_PATH);
     	return $this->_view->headScript()->appendFile($resourceUrl);
    }
    
    public function initJQueryUi()
    {
     	$resourceUrl = $this->buildResourceUrl(self::JQUERY_UI_PATH);
     	return $this->_view->headScript()->appendFile($resourceUrl);
    }
    
    public function initJQueryValidate()
    {
     	$resourceUrlValidate = $this->buildResourceUrl(self::JQUERY_VALIDATE_PATH);
     	$resourceUrlAddMethods = $this->buildResourceUrl(self::JQUERY_VALIDATE_ADDITIONAL_METHODS_PATH);
     	return $this->_view->headScript()->appendFile($resourceUrlValidate)." ".$this->_view->headScript()->appendFile($resourceUrlAddMethods);
    }
    
    public function initJQueryNivo()
    {
     	$resourceUrlNivo = $this->buildResourceUrl(self::JQUERY_NIVO_PATH);
     	$resourceUrlNiviInit = $this->buildResourceUrl(self::JQUERY_NIVO_INIT_PATH);
     	return $this->_view->headScript()->appendFile($resourceUrlNivo)." ".$this->_view->headScript()->appendFile($resourceUrlNiviInit);
    }
    
    public function initJQueryThemeRollerCSS()
    {
     	$resourceUrl = $this->buildResourceUrl(self::JQUERY_THEMEROLLER_CSS);
     	return $this->_view->headLink()->appendStylesheet($resourceUrl);
    }
    
    private function buildResourceUrl($path)
    {
    	$resourceUrl = $this->_view->baseUrl().'/'.$path;
    	return $resourceUrl;
    }
}
?>