<?php

class viewManager {
	var $lang = null;
	var $view = null;
	var $pageObj = null;
	
	public function __construct($lang = _DEFAULT_LANG_) {
		
		$this->lang = $lang;
		$this->pageObj = new  Smarty();
		
	}
	
	public function setLang($lang) {
		
		$this->lang = $lang;
			
	}
	
	public function assign($key, $val) {
		
		$this->pageObj->assign($key, $val);
			
	}
	
	public function display($template) {
		$this->pageObj->assign('lang', $this->lang);
		$this->pageObj->display($template);
		exit;	
		
	}
	
	
	
	
}

?>