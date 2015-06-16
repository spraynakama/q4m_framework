<?php


/**
 * Description of class
 *
 * @author hnakama
 */
class cronHelper {

//put your code here
  public $db = null;
  public $is_db = false;

  public function __construct($is_db = false) {

    if ($is_db) {
      $this->connectDB();
    }
  }

  public function connectDB() {
    $this->db = dataSource::getDataSource('dbConnecter', 'db_inc');
  }

  public function useDB($bool) {

    $this->is_db = $bool;
  }

  public function useHelper($file) {

    if (file_exists(_SYS_DIR_ . _HELPER_DIR_ . 'class.' . $file . '.php')) {

      include_once(_HELPER_DIR_ . 'class.' . $file . '.php');
    } else {
      q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _HELPER_DIR_ . 'class.' . $file . '.php', __FILE__, __LINE__);
      exit;
    }
  }

  public function useModel($name = null) {

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

      include_once(_SYS_DIR_ . $modelfile);
      return $model = new $modelname($this->db);
    } else {
      q4mSystem::haltOnError('The file is not found', $modelfile, __FILE__, __LINE__);
      exit;
    }
  }


}
