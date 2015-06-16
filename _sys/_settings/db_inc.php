<?php
/**
* DB connection settings.
*
* @author H. Nakama
*/

	$db_type = 'mysql';
	$db_host = 'localhost';
	$db_name = 'curly';
	$db_user = 'curly';
	$db_pass = 'wwL6dK';
	$db_port = 3306;
	
  $charset = 'utf8';
// All the table names should have a common prefix
// to avoid table name collision with other system, in case.
// _DB_PF_ is used in SQL.
	if (!defined('_DB_PF_')) {define('_DB_PF_', 'c_');}

?>