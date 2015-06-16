<?php

/**
 * These are general settings used in whole system,
 * no matter program is called in any subdirectory or root directory. 
 * 
 * @author H. Nakama
 */
// set this to true in production phaase.
ini_set('display_errors', 1); //true or false, 1 or 0;
// IE fails to download file if the header is issued.
if (isset($_REQUEST['no_sess'])) {
    if ($_REQUEST['no_sess'] != 0) {
        session_start();
    }
} else {
    session_start();
}

// For multi-lingual use.  Default language is used when it's mono-linugal use
// or any attempt to find language related files failed.
if (!defined('_DEFAULT_LANG_'))
    define('_DEFAULT_LANG_', 'ja');

// This becomes the column name of the language settings, and the key for the session
// that stores language setting.
if (!defined('_LANG_NAME_'))
    define("_LANG_NAME_", 'user_lang');

// Character set for the DB
if (!defined('_CHAR_SET_'))
    define('_CHAR_SET_', 'UTF8');

// The directory that points to _core directory.
if (!defined('_CORE_DIR_'))
    define('_CORE_DIR_', '_core' . _DS_);

// The directory that points to _settings directory.
// This directory stores system-wide settings.
if (!defined('_SETTINGS_DIR_'))
    define('_SETTINGS_DIR_', '_settings' . _DS_);

// The directory that points to languages directory.
// Stores language jason.
if (!defined('_LANG_DIR_'))
    define('_LANG_DIR_', _MY_DIR_ . "languages" . _DS_);

// The directory that points to model directory. 
// Stores model classes files.
if (!defined('_MODEL_DIR_'))
    define('_MODEL_DIR_', _MY_DIR_ . "model" . _DS_);

// The directory that points to _data directory. 
// Data handler classes such as DB connection classes are stored.
if (!defined('_DC_DIR_'))
    define('_DC_DIR_', _SYS_DIR_ . "_data" . _DS_);

// The directory that points to _helper directory. 
// Stores classes that have specific functions such as sanitizing and login procedure.
if (!defined('_HELPER_DIR_'))
    define('_HELPER_DIR_', "_helper" . _DS_);

// The directory that stores cotrollers.
if (!defined('_CONTROLLER_DIR_'))
    define('_CONTROLLER_DIR_', _SYS_DIR_ . _MY_DIR_ . "controller" . _DS_);

// The class that handles authentication.
if (!defined('_AUTH_MANAGER_'))
    define('_AUTH_MANAGER_', _CORE_DIR_ . "class.authManager.php");

// The path from the DocumentRoot to root directory of this sytem.
if (!defined('_BASE_PATH_'))
    define("_BASE_PATH_", str_replace($_SERVER['DOCUMENT_ROOT'], '', _BASE_DIR_));

if (!defined('_SMARTY_COMMON_'))
    define('_SMARTY_COMMON_', 'common');

if (!defined('_TPL_EXT_')) {
    define('_TPL_EXT_', 'tpl');
}
// default limit for search from DB
if (!defined('_LIMIT_')) {
    define('_LIMIT_' , 20);
}

include_once(_SETTINGS_DIR_ . "smarty_inc.php");
include_once(_CORE_DIR_ . "class.q4mSystem.php");
include_once(_CORE_DIR_ . "class.q4mController.php");
include_once(_CORE_DIR_ . "class.dataSource.php");
include_once(_CORE_DIR_ . "class.q4mModel.php");
include_once(_DC_DIR_ . "class.dbConnecter.php");
?>