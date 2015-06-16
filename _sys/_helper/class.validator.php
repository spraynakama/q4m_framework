<?php
class validator {
	
	var $RULES;
	var $VAL;
	var $ERRORS = array();
	var $IS_ERROR = array();
	var $encode;
	var $LIST;
	var $ignore = array(
	'error'=> 1,
	'error_tag' => 1, 'multi' => 1,
	'required_with' => 1,
	'data_file' => 1, 
	'delimiter' => 1,
	'cond_name' => 1,
	'cond_value' => 1,
	'var_name' => 1,
	'var_count' => 1,
	'empty_first' => 1
	);
	
/*********************************************************

コンストラクタ： 
$rules： 別ファイルで設定。必須。
$encode：デフォルトutf8
*********************************************************/
	function __costruct($rules, $encode = 'utf8', $VAL = null) {
		
		$this->RULES = $rules;
		$this->encode = $encode;
		
		if ($VAL == '') {$this->VAL = $_POST;} else {$this->VAL = $VAL;}
			
	}
	
	function validate($name = null) {
		if ($name == '') {
			print "inputのnameを指定してください。at ".__FILE__." line ".__LINE__;
			
		}
		
		$rules = $this->RULES[$name];
		if (!count($rules)) { 
			print $name."の条件を指定してください。at ".__FILE__." line ".__LINE__;
		}
		foreach ($rules as $key => $val) {
		
			if ($this->ignore[$key]) {continue;}
			
			if ($this->$key($val, $name)) {
				$this->ERRORS[$rules['error_tag']][] = $rules['error'][$key];
				$this->IS_ERROR[$name] = 1;
				return;
			}
			
		}
		
	}
	
	function required($val, $name) {
		
		if ($this->RULES[$name]['empty_first'] == 1 && $this->VAL[$name] == "0") {
			$this->VAL[$name] = '';
		}
			if ($val == 1) {
				
				if ($this->RULES[$name]['multi'] == 1) {

					if (count($this->VAL[$name])) {
						return 0;
					} else {
						return 1;	
					}
				} else {
					if ($this->VAL[$name] == '') {
						return 1;
					} else {
						return ;	
					}
				}
			} else if ($val == 2) {
				return $this->cond_required($val, $name);
			} else if ($val == 3) {
				return $this->required_with($val, $name);
			} else {
				return;	
			}
	}
	
	function cond_required($val, $name) {
		
		$other_name = $this->RULES[$name]['cond_name'];
	
		$is_cond = 0;
		if (is_array($this->VAL[$other_name])) {
			
			foreach ($this->VAL[$other_name] as $value) {
				if ($value == $this->RULES[$name]['cond_value']) {
					$is_cond = 1;
					break;
				}
			}
			
		} else if ($this->VAL[$other_name] == $this->RULES[$name]['cond_value']) {
				$is_cond = 1;
		}

		if ($is_cond == 1) {
			
			if ($this->VAL[$name] == '') {
				return 1;	
			} else {
				return 0;	
			}
			
		} else {
			return 0;	
		}
	}
	
	function required_with($val, $name) { ///他の値と合わせてどちらかが必須の場合、$valで指定されたnameの値が空の時エラーとして1を返す。

		if ($this->VAL[$name] == '') { //自分がエラー
			
			//もし、指定された他のものは、複数、var_nameで指定されている場合、
		
			$other_name = $this->RULES[$name]['required_with'];
			
			foreach($other_name as $other) {

				if ($this->RULES[$other]['var_name'] != '') {
					for ($i = 0; $i <= $this->RULES[$other]['var_count']; $i++) {
						$key = $this->RULES[$other]['var_name'].$i;
						
						if ($this->VAL[$key] != '') {
							
							return 0;	
						}
					}
				} else if ($this->VAL[$other] != '' || count($this->VAL[$other])) {
					return 0;
				}
				
			}
			return 1;
			
		}
		return 0;
		
	}
	
	function count($val, $name) {
		list ($from, $to) = explode(',', $val);
		
		if ($this->VAL[$name] != '') {
			if ($this->VAL[$name] < $from || $this->VAL[$name] > $to) {
				return 1;
			}
		}
		
		return;
		
	}
	
	function maxlength($val, $name) {
		
		
		if ($this->RULES[$name]['multi'] == 1) {
			
			foreach($this->VAL[$name] as $key => $con) {
				if (mb_strlen($con, $this->encode) > $val) {
					return 1;	
				}
			}
			return;
			
		} else {
			if (mb_strlen($this->VAL[$name], $this->encode) > $val) {
				return 1;	
			} else {
				return;
			}
		}
	}
	
	
	function minlength($val, $name) {
		
		if ($this->VAL[$name] == '') {return;} //空ならチェックしない
		if ($this->RULES[$name]['multi'] == 1) {
			
			foreach($this->VAL[$name] as $key => $con) {
				if (mb_strlen($con, $this->encode) < $val) {
					return 1;	
				}
			}
			return;
			
		} else {
			if (mb_strlen($this->VAL[$name], $this->encode) < $val) {
				return 1;	
			} else {
				return;
			}
		}
	}
	
	function length($val, $name) {
		
		if ($this->VAL[$name] == '') { return; }
		if ($this->RULES[$name]['multi'] == 1) {
			
			foreach($this->VAL[$name] as $key => $con) {
				if (mb_strlen($con, $this->encode) != $val) {
					return 1;	
				}
			}
			return;
					
		} else {
			if (mb_strlen($this->VAL[$name], $this->encode) != $val) {
				return 1;	
			} else {
				return;
			}
		}
	}
	
	function limit_array($val, $name) {
		
		if (!count($this->LIST[$val])) {
			print "比較対象リストが与えられていません。at ".__FILE__." line ".__LINE__;
			return;	
		}
		
		$list = $this->LIST[$val];

		if ($this->RULES[$name]['multi'] == 1) {
			
				$isthere = array();
			foreach($this->VAL[$name] as $key => $con) {
				
				foreach($list as $key => $VAL) {
					
						if ($key == $con) {
							$isthere[] = 1;
						}
				}
			}
			if (count($isthere) == count($this->VAL[$name])) {
				return 0;
			} else {
				return 1;
			}

		}  else {
			
			foreach($list as $key => $VAL) {
				
					if ($key == $this->VAL[$name]) {
						return 0;
					}
			}
			return 1;
		}
		
	}
	
	function limit_char($val, $name) {
		
		if ($this->VAL[$name] == '') { return; }
		/// $val の中身（num, hira, kana）などによってそれぞれの関数に飛ばす。
		return $res = $this->$val($name);
	}
	
	function num($name) {
		if ($this->RULES[$name]['multi'] == 1) {
			foreach($this->VAL[$name] as $key => $con) {
				if(!preg_match("/^[0-9]+$/",$con)) {
					return 1;
				}
			}
			return 0;	
		} else {
			
			if(preg_match("/^[0-9]+$/",$this->VAL[$name])) {
				return 0;
			} else {
				return 1;	
			}
		}
	}
	
	function hira($name) {
		
		if ($this->VAL[$name] == '') { return; }
		if ($this->RULES[$name]['multi'] == 1) {
			foreach($this->VAL[$name] as $key => $con) {
			if (!preg_match("/^[ぁ-んー　]+$/u", $con)) {  
					return 1;
				}
			}
			return 0;	
		} else {
			
			if (preg_match("/^[ぁ-んー　]+$/u", $this->VAL[$name])) {  
				return 0; 
			} else {
				return 1;	
			}
		}
	}
	
	function kana($name) {

		if ($this->VAL[$name] == '') { return; }
		if ($this->RULES[$name]['multi'] == 1) {
			foreach($this->VAL[$name] as $key => $con) {
			if (!preg_match("/^[ァ-ヶー　]+$/u", $con)) {  
					return 1;
				}
			}
			return 0;	
		} else {
			
			if (preg_match("/^[ァ-ヶー　]+$/u", $this->VAL[$name])) {  
				return 0; 
			} else {
				return 1;	
			}
		}
	}
	
	function limit_expression($val, $name) {

		if ($this->RULES[$name]['multi'] == 1) {
			foreach($this->VAL[$name] as $key => $con) {
			if (!preg_match($val, $con)) {  
					return 1;
				}
			}
			return 0;	
		} else {
			
			if (preg_match($val, $this->VAL[$name])) {
				return 0;
			} else {			
				return 1;
			}
		}
	}
	
	function equal_to($val, $name) {
		if ($val != $this->VAL[$name]) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function multi_count($val, $name) {
		if ($val != count($this->VAL[$name])) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function multi_min_count($val, $name) {
		if ($val > count($this->VAL[$name])) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function multi_max_count($val, $name) {
		if ($val < count($this->VAL[$name])) {
			return 1;
		} else {
			return 0;
		}
	}
}

?>