<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


ini_set('display_errors', 1); //true or false, 1 or 0;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Directory separator ( / or \ ) usually.
if (!defined('_DS_'))
  define('_DS_', DIRECTORY_SEPARATOR);

// The name of the top directory that this program is saved under.
if (!defined('_MY_DIR_'))
  define('_MY_DIR_', '_cron' . _DS_);

// The directory one level upper from _MY_DIR_
if (!defined('_BASE_DIR_'))
  define('_BASE_DIR_', str_replace(_MY_DIR_, '', __DIR__ . _DS_)); //<- need to point the _sys directory.


// The main framework is saved under this.
if (!defined('_SYS_DIR_'))
  define('_SYS_DIR_', _BASE_DIR_ );

// This points to the ini.php that starts program.
if (!defined('_INIT_'))
  define('_INIT_', _SYS_DIR_ .  _DS_ . '_settings' . _DS_ . 'init.php');

if (!defined('_DEFAULT_LANG_'))
  define('_DEFAULT_LANG_', 'en');
if (!defined('_CHAR_SET_'))
  define('_CHAR_SET_', 'UTF8');

if (!defined('_CORE_DIR_'))
  define('_CORE_DIR_', _SYS_DIR_ .  _DS_ . '_core' . _DS_);
if (!defined('_SETTINGS_DIR_'))
  define('_SETTINGS_DIR_', _SYS_DIR_ .  _DS_ . '_settings' . _DS_);
if (!defined('_LANG_DIR_'))
  define('_LANG_DIR_', _MY_DIR_ . "languages" . _DS_);
if (!defined('_MODEL_DIR_'))
  define('_MODEL_DIR_', _SYS_DIR_ .  _DS_ .  _MY_DIR_ . "model" . _DS_);
if (!defined('_DC_DIR_'))
  define('_DC_DIR_', _SYS_DIR_ .  _DS_ .  "_data" . _DS_);
if (!defined('_HELPER_DIR_'))
  define('_HELPER_DIR_', _SYS_DIR_ . "_helper" . _DS_);
if (!defined('_CONTROLLER_DIR_'))
  define('_CONTROLLER_DIR_', _SYS_DIR_ .  _DS_ . _MY_DIR_ . "controller" . _DS_);


include_once(_CORE_DIR_ . "class.q4mSystem.php");
include_once(_DC_DIR_ . "class.dbConnecter.php");
include_once(_CORE_DIR_ . "class.dataSource.php");
include_once(_CORE_DIR_ . "class.q4mModel.php");
include_once(_HELPER_DIR_ . "class.cronHelper.php");

