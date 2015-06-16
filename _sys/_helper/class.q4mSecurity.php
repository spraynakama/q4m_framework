<?php

	class q4mSecurity {
		
		public function sanitize(&$INPUT) {
			
			foreach ($INPUT as $key => $val) {
				
					$key = htmlspecialchars($key);
					$val = str_ireplace(array('delete', 'truncate', 'select', ';', '='), array('', '', '', '&#059;', '&#061;'), $val);
					
					$INPUT[$key] = htmlspecialchars($val);
					
				
			}
			
			
		}
		
		
	}


?>