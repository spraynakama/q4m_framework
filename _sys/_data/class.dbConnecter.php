<?php

class dbConnecter {
	var $dbLink = null;

	var $is_transaction = false;
	
//----------------------------------
// コンストラクタ　コネクション開始
//----------------------------------	
	function __construct($db_type = 'mysql', $db_host = 'localhost', $db_name = '', $db_user = '' , $db_pass = '', $db_port = 3306, $charset = 'UTF8') {

		try {
			
			$dsn = $db_type . ':host=' . $db_host . ';dbname=' . $db_name . ';port=' . $db_port;
			if ($db_type == 'mysql') {
				$dsn .= ';charset=' . $charset;
			}
			
                        
			$this->dbLink = new PDO($dsn, $db_user, $db_pass);
			if ($db_type == 'mysql') {
                            $this->dbLink->exec('set names ' . $charset);
                        }
		} catch (PDOException $e) {
			q4mSystem::haltOnError('DB Connection error', get_class($this) . ' ' . $e->getMessage(), __FILE__, __LINE__);
			exit;

		}

	}

//----------------------------------
// アップデート・デリート用
//----------------------------------	

	public function update($string, $values=NULL, $column=''){
	
	//print $string."<br />\n";
		try {
			$stmt=$this->dbLink->prepare($string);
			//var_dump($values);
			if (count($values)) {
				$stmt->execute($values);
			} else {
				$stmt->execute();
			}
			
				$stmt = null;
			return $this->dbLink->lastInsertId($column);
				
		} catch (PDOException $e){		
			if ($this->is_transaction) {
				$this->rollBack();
				$this->is_transaction = false;
			}
			q4mSystem::haltOnError('Error while transaction' , get_class($this) .  $e->getMessage() , __FILE__ , __LINE__);
			return false; 		
		}
	}

//----------------------------------
// クエリー用
//----------------------------------	

	public function query($string,$values=null) {
	
	
		$stmt =$this->dbLink->prepare($string);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		try {	
								
				$stmt->execute($values);
									
				return $stmt;
						
		} catch (PDOException $e) {
			q4mSystem::haltOnError('Query error', get_class($this) .  $e->getMessage() , __FILE__ , __LINE__);
			exit;
			
		}

	}

//----------------------------------
// トランザクション開始
//----------------------------------
  public function transactionStart() {
		
		$this->dbLink->beginTransaction();
		$this->is_transaction = true;
	}
	
//----------------------------------
// Commit
//----------------------------------
	public function commit() {
		
		$this->dbLink->commit();
		$this->is_transaction = false;
		
	}

	
//----------------------------------
// Commit
//----------------------------------
	public function rollBack() {
		
		$this->dbLink->rollBack();
		$this->is_transaction = false;
		
	}
	//----------------------------------
// コネクション解除
//----------------------------------	
	public function close(){
		if( $this->dbLink != null ){
		 	$this->dbLink = null;
		}
	}

}


?>
