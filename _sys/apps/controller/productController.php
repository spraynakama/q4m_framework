<?php

class productController extends q4mController {

	protected function index() {
		
		$this->display();
		
		exit;
		
	}
        
        protected function detail($no) {
            
           $this->display();
        }
	
	
}

?>