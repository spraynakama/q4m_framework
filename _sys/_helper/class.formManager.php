<?php

class formApp {
	
	var $OM;
	var $SV;
	var $lists = array();
	var $pageObj;
	
	function __construct($validation_list, $settings, &$pageObj)	{
		$this->pageObj = $pageObj;
		//var_dump($settings);
		$this->OM = new optionManager();
		$this->SV = new sprayValidator($validation_list);
		$this->sanitize();
		
		foreach ($settings as $key => $list) {
			//選択肢タイプのものの配列を作る。フォームのnameがキーになる。
			//SV-LISTに入れるのは、バリデーションの時に、選択肢以外の入力をはじくための
			//比較用配列を作るため。
			$this->OM->make_list($key, $list);
			$this->lists[$key] = 1;
					///二重配列になっている選択肢はチェック用に単純な配列に書き出す
				if ($this->array_depth($this->OM->OPS[$key]) == 2) {
					foreach ($this->OM->OPS[$key] as $n => $P) {
						if ($P[1] == '') { continue;}
						$PLIST[$n] = $P[1];
					}
					$this->SV->LIST[$key.'_list'] = $PLIST;					
				}  else {
			
					$this->SV->LIST[$key.'_list'] = $this->OM->OPS[$key];	
				}			
		}

		//var_dump($this->OM->OPS);
		
	}
	
	/************************************
	form.phpからはこれが呼ばれるだけ。
	*************************************/
	function excute($mode = 'new') {
		
		if ($mode != 'return' && $mode != 'confirm' && $mode != 'accept') {
			$mode = 'new';	
		}
		$mode .= 'page';
		$this->$mode();
	}
	
	function newpage() {
	//新規のトークンを生成
		$token = $this->getRandomString(_TOKEN_LENGTH_);
		$_SESSION[_SESSION_][_TOKEN_NAME_] = $token;
		
		$template = _FORM_TEMPLATE_;
		$this->pageObj->assign(_TOKEN_NAME_, $token);
		
		foreach($this->lists as $key => $val) {
					
			$this->pageObj->assign($key._LOOP_, $this->OM->OPS[$key]);

		}
		
		$this->pageObj->display($template);
		exit;	
		
	}
	
	function returnpage() {
	//入力されたものをフォームにセットしてフォームを表示させる。
	$template = _FORM_TEMPLATE_;
	
		if ($_POST[_TOKEN_NAME_] != $_SESSION[_SESSION_][_TOKEN_NAME_]) {
			$this->newpage();
		}
		
		$this->pageObj->assign(_TOKEN_NAME_, $_SESSION[_SESSION_][_TOKEN_NAME_]);	
		$this->validate();
		
		if (count($this->SV->ERRORS)) {
			
			foreach($this->SV->ERRORS as $key => $ERR) {
			/// 設定のerror_tagとkeyとテンプレートのエラーの入る変数が一致している
				$this->pageObj->assign($key, implode(_ERROR_SEPARATOR_, $ERR));
			}
			
		}
		/////////
		$this->assignTemplate();
	
		$this->pageObj->display($template);
		exit;
			
			
	}
	
	function confirmpage() {
			
		if ($_POST[_TOKEN_NAME_] != $_SESSION[_SESSION_][_TOKEN_NAME_]) {
			$this->newpage();
		}
		
		$this->pageObj->assign(_TOKEN_NAME_, $_SESSION[_SESSION_][_TOKEN_NAME_]);
			
		$this->validate();
		
		
		////// エラーがあった場合はフォームにエラーを表示さえる
		if (count($this->SV->ERRORS)) {
			
			foreach($this->SV->ERRORS as $key => $ERR) {
			/// 設定のerror_tagとkeyとテンプレートのエラーの入る変数が一致している
				$this->pageObj->assign($key, implode(_ERROR_SEPARATOR_, $ERR));
			}
			
			$this->assignTemplate();
			$this->pageObj->assign(_ERROR_FLAG_, 1);
			
			$template = _FORM_TEMPLATE_;
			
		//// エラーがない場合は確認画面を表示させる		
		} else {
			$this->pageObj->assign(_POST_NAME_, $_POST);
			
			$this->assignTemplate();
			
			$template = _CONFIRM_TEMPLATE_;
		}
	
		$this->pageObj->display($template);
		exit;		
	}

	function acceptpage() {
				
		if ($_POST[_TOKEN_NAME_] != $_SESSION[_SESSION_][_TOKEN_NAME_]) {
			$this->newpage();
		}
		
		//入力値が確認画面で改ざんされている可能性があるので、もう一度バリデート
	
		$this->validate();
		////// エラーがあった場合はフォームにエラーを表示さえる
		if (count($this->SV->ERRORS)) {
			
			foreach($this->SV->ERRORS as $key => $ERR) {
			/// 設定のerror_tagとkeyとテンプレートのエラーの入る変数が一致している
				$this->pageObj->assign($key, implode(_ERROR_SEPARATOR_, $ERR));
			}
			
			$template = _FORM_TEMPLATE_;
			$this->pageObj->assign(_TOKEN_NAME_, $_SESSION[_SESSION_][_TOKEN_NAME_]);
			$this->assignTemplate();	
			$this->pageObj->assign(_ERROR_FLAG_, 1);
	
			$this->pageObj->display($template);
			exit;	
		} else {
		//エラーが無かったらメール送信
			$serial = $this->getSerial(_SERIALFILE_);
			
			$this->pageObj->assign(_SERIAL, $serial);
			$template = _MAIL_TEMPLATE_;
			$this->assignTemplate();	
			
			include_once(_SENDMAIL_FUNC_);
			
			sendmail($this->OM, $this->pageObj, $template);
			
			//トークン作り直し
			$token = $this->getRandomString(_TOKEN_LENGTH_);
			$_SESSION[_SESSION_][_TOKEN_NAME_] = $token;
			///完了画面表示、終了
			$this->pageObj->clear_all_assign();
			$this->pageObj->display(_THANKS_HTML_);
			exit;	
			
		}	
		
	}

	function validate() {
		
		foreach($this->SV->RULES as $key => $SV) {
				
				$this->SV->validate($key);			
		}
	
	}

	function assignTemplate() {
	
	
		///選択肢タイプのものはここで選択されたものにselectedを入れとく
		
		foreach ($this->lists as $key => $val) {
			//print $key."<br />\n";
			if (is_array($_POST[$key]) && !$this->SV->ERRORS[$key]) {
								
				foreach($_POST[$key] as $k => $v) {
					$this->OM->OPS[$key][$v]['selected'] = ' selected="selected"';
					$this->OM->OPS[$key][$v]['checked'] = ' checked="checked"';
				}
								
			} else if (count($_POST[$key]) && !$this->SV->ERRORS[$key]) {
				$this->OM->OPS[$key][$_POST[$key]]['selected'] = ' selected="selected"';
				$this->OM->OPS[$key][$_POST[$key]]['checked'] = ' checked="checked"';
			}
			
			$this->pageObj->assign($key._LOOP_, $this->OM->OPS[$key]);
			
		}
		
		foreach ($_POST as $key => $val) {
			if ($key == _TOKEN_NAME_) {continue;}
			if ($this->lists[$key]) {
			
				if (is_array($_POST[$key])) {
					$LIST = array();
					if (count($_POST[$key])) {
						foreach ($_POST[$key] as $name => $v) {
							$LIST[] = $this->OM->OPS[$key][$v];	
							$this->pageObj->assign($key, $LIST);
						}
					}				
				} else {
					
					$this->pageObj->assign($key, $this->OM->OPS[$key][$_POST[$key]][$this->array_depth($this->OM->OPS[$key])-1]);
				}
	
			} else {
				$this->pageObj->assign($key, $val);
				
			}
		}
	
	
	}	
		
	function sanitize() {
		
		foreach ($_POST as $name => $val) {
			
			if (is_array($val)) {
				foreach($val as $k => $v) {
					$v = htmlspecialchars($v);
					$v = strip_tags($v);
					$v = preg_replace(_SQL_ESCAPE_, '', $v);
					$_POST[$name][$k] = $v;
					
				}
				
			} else {	
				$val = htmlspecialchars($val);
				$val = strip_tags($val);
				$val = preg_replace(_SQL_ESCAPE_, '', $val);
				$_POST[$name] = $val;
			}
			
		}
		
	}
	
	function array_depth($a){
		
		$d = 1;
		
		foreach ($a as $key => $val) {
			
			if ($val[1] != '') {$d = 2; break;}
				
		}
		
		return $d;
	}
	
	function getRandomString($nLengthRequired = 12){
		$sCharList = _TOKEN_CHARS_;
		mt_srand();
		$sRes = "";
		for($i = 0; $i < $nLengthRequired; $i++)
			$sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
		return $sRes;
	}
	
	
	function getSerial($file) {
		if (file_exists($file)) {
			
			$fh = fopen($file, "r+");
			 if (flock($fh, LOCK_EX)) {
				 $buffer = chop(fread($fh, filesize($file)));
				 $buffer++;
				 rewind($fh);
				 fwrite($fh, $buffer);
				 fflush($fh);
				 ftruncate($fh, ftell($fh));    
				 flock($fh, LOCK_UN);
	
			}
			 
			
		} else {
		   $fh = fopen($file, 'w+');
		   fwrite($fh, "1");
		   $buffer="1";
		}
		fclose($fh);
		chmod($file, 0666);
		return $buffer;
		
	}

}

?>