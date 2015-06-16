<?php
// directory dependant settings

// System name
if (!defined('_SYSTEM_NAME_')) define("_SYSTEM_NAME_", 'Curly ver. 0.1');

// Session key shared with programs that include this define file.
if (!defined('_SESS_MY_KEY_')) define('_SESS_MY_KEY_', 'CURLY');

// Directory separator ( / or \ ) usually.
if (!defined('_DS_'))		define('_DS_', DIRECTORY_SEPARATOR);

// The name of the top directory that this program is saved under.
if (!defined('_MY_DIR_'))	define('_MY_DIR_', 'apps' . _DS_);

// The top path the URL this program pointed to.
if (!defined('_MY_PATH_'))	define('_MY_PATH_',  '/');

// The directory one level upper from _MY_DIR_
if (!defined('_BASE_DIR_')) define('_BASE_DIR_', str_replace(_MY_DIR_, '', __DIR__ . _DS_)); //<- need to point the _sys directory.

// The main framework is saved under this.
if (!defined('_SYS_DIR_'))  define('_SYS_DIR_', _BASE_DIR_ . '_sys' . _DS_);

// This points to the ini.php that starts program.
if (!defined('_INIT_'))     define('_INIT_', _SYS_DIR_ . _DS_ . '_settings' . _DS_ . 'init.php');

?>