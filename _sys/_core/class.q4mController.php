<?php

/**
 * q4mController
 *
 * This is the super class of controller, takes care of initializing view instance (smarty) and model instance (PDO)
 * If specified by the subclass, initiates authentication procedure.
 * 
 * @Auther H. Nakama
 * @since PHP 5.3
 */
class q4mController {

  public $view = null;
  public $template = null;
  public $default_method = null;
  public $lang = null;
  public $template_ext = _TPL_EXT_;
  public $smarty_conf_ext = 'cnf';
  protected $class_basename = '';
  public $base_path = _BASE_PATH_;
  public $is_view = false;
  public $is_auth = false;
  public $db = null;
  public $is_db = false;
  public $lang_file = null;
  public $lang_data = null;
  public $smarty_common = null;

  /**
   * Initialising the class.
   * @param $is_view: bool, deault value = true. Set this to true if smarty is used.
   * @param $is_auth: bool, deault value = false. Set this to true if all controllers require Authentication.
   * @param $is_db: bool, deault value = false.  Set this to true if all controllers require database connection.
   * @return none
   */
  function __construct($is_view = true, $is_auth = false, $is_db = false) {

    $this->useHelper('q4mSecurity');
    q4mSecurity::sanitize($_GET);
    if (isset($_GET['lang'])) {
      $this->lang = $_GET['lang'];

      $_SESSION[_SESS_MY_KEY_]['lang'] = $_GET['lang'];
    } else if (isset($_SESSION[_SESS_MY_KEY_]['lang'])) {
      $this->lang = $_SESSION[_SESS_MY_KEY_]['lang'];
    } else {
      $this->lang = _DEFAULT_LANG_;
    }

    //This guy becomes the directory name of the template.
    $this->class_basename = str_ireplace('Controller', '', get_class($this));

    $this->is_view = $is_view;

    if ($this->is_view) {
      $this->initView();
    }
    if ($is_db) {
      $this->connectDB();
    }
  }

  /**
   * Create database connection instance.
   * @param none
   * @return none
   */
  public function connectDB() {

    $this->db = dataSource::getDataSource('dbConnecter', 'db_inc');
  }

  /**
   * Sets values of $is_db.
   * @param $bool: bool
   * @return none
   */
  public function useDB($bool) {

    $this->is_db = $bool;
  }

  /**
   * Sets language.  Default is specified in ini.php
   * @param $lang: symbol, ja = Japanese, en = English
   * @return none
   */
  public function setLang($lang) {
    $this->lang = $lang;
  }

  /**
   * Sets values of $is_auth.
   * @param $bool: bool
   * @return none
   */
  public function useAuth($bool) {
    $this->is_auth = $bool;
  }

  /**
   * Includes spacified helper file
   * @return none;
   */
  public function useHelper($file) {

    if (file_exists(_SYS_DIR_ . _HELPER_DIR_ . 'class.' . $file . '.php')) {

      include_once(_HELPER_DIR_ . 'class.' . $file . '.php');
    } else {
      q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _HELPER_DIR_ . 'class.' . $file . '.php', __FILE__, __LINE__);
      exit;
    }
  }

  /**
   * Sets name of the method that is called after constructer.
   * @param $method: method name
   * @return none
   */
  public function setDefaultMethod($method) {

    $this->default_method = $method;
  }

  /**
   * Sets base path in the URL this controller is colled.
   * Used for the path in the templates.
   * @param $path
   * @return none
   */
  public function setBasePath($path) {

    $this->base_path = $path;
  }

  /**
   * Triggers default method.
   * Before it kicks the method, it seeks for methods specified in beforeAction().
   * Default settings are overridden in beforeAction();
   * DB connections and authentications are excuted if they are set true.
   * @param $parameter
   * @return none
   */
  public function action($parameter = null) {

    if (method_exists($this, 'beforeAction')) {
      $this->beforeAction();
    }


    if ($this->is_db && !$this->db) {
      $this->connectDB();
    }

    if ($this->is_auth) {
      include_once(_AUTH_MANAGER_);
      $this->lang = authManager::auth($this->view);

      if (method_exists($this, 'checkCredential')) {

        $this->checkCredential();
      }
    }

    if (!method_exists($this, $this->default_method)) {
      q4mSystem::haltOnError('The method is not found', get_class($this) . '::' . $this->default_method, __FILE__, __LINE__);
      exit;
    }

    $this->{$this->default_method}($parameter);
  }

  /**
   * Called from indexController();
   */
  public function logOut() {
    include_once(_AUTH_MANAGER_);
    authManager::logOut($this->view);
  }

  /**
   * Creates Smarty instance, and takes care of minimum settings.
   * Loads common config file here.
   */
  protected function initView() {

    $this->smarty_common = _SMARTY_COMMON_ . '.' . $this->smarty_conf_ext;

    include_once(_SMARTY_);
    $this->view = new Smarty();
    $this->view->template_dir = $this->view->config_dir = _SYS_DIR_ . _TEMPLATES_;
    if (!is_writable(_SYS_DIR_ . _TEMPLATES_C_)) {
        print 'Fatal error. ' . _SYS_DIR_ . _TEMPLATES_C_ . ' is not writeable';
        exit;
    }
    $this->view->compile_dir = _SYS_DIR_ . _TEMPLATES_C_;
    if (file_exists(_SYS_DIR_ . _TEMPLATES_ . _MY_DIR_ . $this->lang . _DS_ . $this->smarty_common)) {
      $this->view->configLoad(_MY_DIR_ . $this->lang . _DS_ . $this->smarty_common);
    }
  }

  /**
   * Can change the extention of template files.  Defaults to .html.
   */
  protected function setTemplateExt($ext) {

    $this->template_ext = $ext;
  }

  /**
   * Can change the extention of smarty config file. Deault is .cnf.
   */
  protected function setSmartyConfigExt($ext) {

    $this->smarty_conf_ext = $ext;
  }

  /**
   * Sets a template name for Smarty.
   */
  public function setTemplate($template) {

    $this->template = $template;
  }

  public function loadSmartyConfig($conf) {
    $config = _MY_DIR_ . $this->lang . _DS_ . $this->class_basename . _DS_ . $conf . '.' . $this->smarty_conf_ext;
    if (file_exists(_SYS_DIR_ . _TEMPLATES_ . $config)) {
      $this->view->configLoad($config);
    }
  }

  /**
   * Smarty "display" method can be called directly by $this->view->display(<template name>);
   * But this method automates without specifying a template name and a language file.
   * Rules to specify template names;
   * 1. If the template name is not given, the path to the file with the chosen language prefix and the default template name is generated. 
   * 2. If the file above does not exist, the path to the file with the default language prefix and the default template name is generated.
   * 3. If the template name is given, the path to the file with the language prefix is generated.
   * 4. If the file above is not found, the path to the file with the default langugage prefix is generated.
   *
   * if the child controller has beforeDisplay() method, it is excuted first.
   * @param string $tmp: template name before extension.
   * @return none.
   */
  protected function display($tmp = null, $conf = null) {

    if (method_exists($this, 'beforeDisplay')) {
      $this->beforeDisplay();
    }
    
    $template = $this->makeTemplatePath($tmp);

    if ($conf == null) {
      if ($tmp == null) {
        $config = _MY_DIR_ . $this->lang . _DS_ . $this->class_basename . _DS_ . $this->template . '.' . $this->smarty_conf_ext;
      } else {
        $config = _MY_DIR_ . $this->lang . _DS_ . $this->class_basename . _DS_ . $tmp . '.' . $this->smarty_conf_ext;
      }
    } else {
      $config = _MY_DIR_ . $this->lang . _DS_ . $this->class_basename . _DS_ . $conf . '.' . $this->smarty_conf_ext;
    }

    if (file_exists(_SYS_DIR_ . _TEMPLATES_ . $config)) {
      $this->view->configLoad($config);
    }

    $this->view->assign('base_path', $this->base_path);
    $this->view->assign('lang', $this->lang);
    $this->view->assign('timestamp', time());

    try {

      $this->view->display($template);
      exit;
    } catch (SmartyException $e) {
      q4mSystem::haltOnError($e->getMessage(), get_class($this) . '::' . $this->default_method, __FILE__, __LINE__);
      exit;
    }
  }

  public function makeTemplatePath($tmp = null) {

    $candidates = array();
    if ($tmp == null) {
      $template = _MY_DIR_ . $this->lang . _DS_ . $this->class_basename . _DS_ . $this->template . '.' . $this->template_ext;
      array_push($candidates, $template);
      if (!file_exists(_SYS_DIR_ . _TEMPLATES_ . $template)) {
        $template = _MY_DIR_ . _DEFAULT_LANG_ . _DS_ . $this->class_basename . _DS_ . $this->template . '.' . $this->template_ext;
        array_push($candidates, $template);
      }
    } else {

      $template = _MY_DIR_ . $this->lang . _DS_ . $this->class_basename . _DS_ . $tmp . '.' . $this->template_ext;
      array_push($candidates, $template);

      if (!file_exists(_SYS_DIR_ . _TEMPLATES_ . $template)) {

        $template = _MY_DIR_ . _DEFAULT_LANG_ . _DS_ . $this->class_basename . _DS_ . $tmp . '.' . $this->template_ext;
        array_push($candidates, $template);
      }
    }

    if (!file_exists(_SYS_DIR_ . _TEMPLATES_ . $template)) {

      $files = implode("<br />\n", array_unique($candidates));
      q4mSystem::haltOnError('Any of the flollowing file(s) does not exist', $files, __FILE__, __LINE__);
      exit;
    }
    return $template;
  }
  
  /**
   * Creates a model instance.
   * @param $datasource: a data source file to pass to the model constructer.
   * @param $name: model name. If null, it is derived from the controller name.
   * @return model instance.
   */
  public function useModel($datasource = null, $name = null) {
    if ($name) {
      if (strstr($name, '/')) {
        $names = explode('/', $name);
        $modelpath = $names[0] . _DS_ . 'model' . _DS_ . $names[1];
        $modelname = $names[1] . 'Model';
        $modelfile = $modelpath . 'Model.php';
      } else {
        $modelpath = $name . 'Model';
        $modelname = $name . 'Model';
        $modelfile = _MODEL_DIR_ . $modelpath . '.php';
      }
    } else {
      $modelpath = str_replace('Controller', '', get_class($this)) . 'Model';
      $modelname = $modelpath;
      $modelfile = _MODEL_DIR_ . $modelpath . '.php';
    }


    if (file_exists(_SYS_DIR_ . $modelfile)) {

      include_once($modelfile);
      return $model = new $modelname($datasource);
    } else {
      q4mSystem::haltOnError('The file is not found', $modelfile, __FILE__, __LINE__);
      exit;
    }
  }

}

?>