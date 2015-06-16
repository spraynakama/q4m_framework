<?php

class optionManager {
	
	var $OPS = array();
	var $delim;
	
	function __construct($delim = ',') {
		
		$this->delim = $delim;
			
	}
	
	
	function make_list($key, $list) {
		
		$lines = split("\n", $list);
		
		if ($lines[0] == 'external') {
			
			$this->OPS[$key] = $this->getExtraFile($lines[1]);

		} else {
			foreach($lines as $line) {
				
				$data = split($this->delim, trim($line));
				$this->OPS[$key][] = $data;
				
			}
		}
		 
		return $this->OPS[$key];
	}
	
	
	function makeExternalList($key, $file, $delimiter = ',' , $count = null) {

		if ($file == '') { return; }
		if (!file_exists($file)) {return;}
		
		$list = array();
		if ($data = file_get_contents($file)) {
			$item = array();
			$lines = explode("\n", $data);
			$i = 0;
			foreach ($lines as $line) {
				$dat = explode($delimiter, trim($line));
				
				if ($i == 0) {
					$keys = $dat;
					$i++;
					continue;	
				}
				
				$k = 0;
				foreach($dat as $d) {
					$item[$keys[$k]] = $d;
					$k++;
				}
				
				$item['count'] = $count;
				array_push($list, $item);
				
			}
			
			$this->OPS[$key] = $list;
			return;
			
		} else {return;}
					
	}
	
}

?>