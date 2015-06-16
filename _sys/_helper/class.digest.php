<?php

class digest {
	
	var $auth_datasource;
	
	public function __construct ($auth_datasource = null) {
		
		$this->auth_datasource = $auth_datasource;	
	}
		
	public function auth(&$view = null, $SESSINFO, $auth_datasource){
		
			if (!$_SERVER['PHP_AUTH_DIGEST']){
					$headers = getallheaders();
			
					if ($headers['Authorization']){
							$_SERVER['PHP_AUTH_DIGEST'] = $headers['Authorization'];
					}
			}
		 
		 
			if ($_SERVER['PHP_AUTH_DIGEST']){
					// Checking up the content of PHP_AUTH_DIGEST
					$needed_parts = array(
											'nonce' => true,
											'nc' => true,
											'cnonce' => true,
											'qop' => true,
											'username' => true,
											'uri' => true,
											'response' => true
											);
					$data = array();
				 
					$matches = array();
					preg_match_all('/(\w+)=("([^"]+)"|([a-zA-Z0-9=.\/\_-]+))/',$_SERVER['PHP_AUTH_DIGEST'],$matches,PREG_SET_ORDER);
				 
					foreach ($matches as $m){
							if ($m[3]){
									$data[$m[1]] = $m[3];
							}else{
									$data[$m[1]] = $m[4];
							}
							unset($needed_parts[$m[1]]);
					}
				 
					if ($needed_parts){
							$data = array();
					}
				 
				 	$columns = implode(', ', $SESSINFO);
				  $db = dataSource::getDataSource($this->auth_datasource, 'db_inc');
				 
					$str = 'select ' . $columns . ' from ' . _DB_PF_ . _USER_TABLE_ .' where ' . _USERNAME_ . ' = ?';
					$result = $db->query($str, array($data['username']));
					$db->close();
			
					if ($CRD = $result->fetch()) {
						
						$A1 = md5($data['username'].':'._DIGEST_REALM_.':'.$CRD[_PASS_]);
						$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
						$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

						if ($data['response'] != $valid_response){
								 unset($_SERVER['PHP_AUTH_DIGEST']);
						}else{
				
								foreach ($SESSINFO as $key) {
									if ($key == _PASS_) { continue; }
									$_SESSION[_SESS_MY_KEY_][$key] = $CRD[$key];
								}
								
								return $_SESSION[_SESS_MY_KEY_][_LANG_NAME_];
						
						}
						
					}	
			}
		 
			$this->print_auth_header();
		 
			showError::haltOnError(_DIGEST_FAILED_TXT_);
			exit;
			
	}

	protected function print_auth_header() {
		
			header('HTTP/1.1 401 Authorization Required');
			header('WWW-Authenticate: Digest realm="'._DIGEST_REALM_.'", nonce="'.uniqid(rand(),true).'", algorithm=MD5, qop="auth"');
			header('Content-type: text/html; charset=UTF8');	
	}	
}
?>