<?php
// _AUTH_TYPE_ defines authentication type;
// loginpage: regular user name, password input.  Authentication page is created.
// Required.
if (!defined('_AUTH_TYPE_')) define("_AUTH_TYPE_", 'loginpage');

// _AUTH_ENC_ defines pass word encrypction stored in the data base;
// md5 or sha1.
// Comment out if not used.
//if (!defined('_AUTH_ENC_')) define("_AUTH_ENC_", 'sha1');

// _USER_TABLE_ is the table name which user info is lookup up.
// Required.
if (!defined('_USER_TABLE_')) define("_USER_TABLE_", 'user');

// _USERNAME_ is the column name of the user name in _USER_TABLE_. 
// Required.
if (!defined('_USERNAME_')) define("_USERNAME_", 'loginname');

// _PASS_ is likewise, column name of the password.
// Required.
if (!defined('_PASS_')) define("_PASS_", 'password');


// _USERNAME_NAME_ is the name of the POST value for user name sent from log in page.
// Required.
if (!defined('_USERNAME_NAME_')) define("_USERNAME_NAME_", 'username');


// And the name of the POST value for the password sent from log in page.
// Required.
if (!defined('_PASS_NAME_')) define("_PASS_NAME_", 'password');

$loginerror = array('ja' => 'ユーザ名とパスワードをご確認ください。', 'en' => 'Please check your usename and password.');

// These are the column names fetched from _USER_TABLE_ when authentication succeeded,
// and those values are saved in th session as with these keys.
// Required.
$SESSINFO = array('id', 'name', _USERNAME_, 'admin', _LANG_NAME_, 'shop_code');

$auth_datasource = 'dbConnecter';
?>