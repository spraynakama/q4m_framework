<?php

class loginpage {

    var $auth_datasource;

    public function __construct($auth_datasource = null) {

        $this->auth_datasource = $auth_datasource;
    }

    public function auth(&$view = null, $SESSINFO, $auth_datasource, $loginerror = null) {

        if (isset($_POST[_USERNAME_NAME_]) && isset($_POST[_PASS_NAME_])) {

            $db = dataSource::getDataSource($this->auth_datasource, 'db_inc');

            $columns = implode(', ', $SESSINFO);

            $str = 'SELECT ' . $columns . ' FROM ' . _DB_PF_ . _USER_TABLE_ . ' WHERE ' . _USERNAME_ . ' = ? AND ' . _PASS_ . ' = ?';


            if (defined('_AUTH_ENC_')) {

                $enc = _AUTH_ENC_;
                $password = $enc($_POST[_PASS_NAME_]);
            } else {
                $password = $_POST[_PASS_NAME_];
            }

            $result = $db->query($str, array($_POST[_USERNAME_NAME_], $password));

            if ($CRD = $result->fetch()) {

                foreach ($SESSINFO as $key) {
                    $_SESSION[_SESS_MY_KEY_][$key] = $CRD[$key];
                }

                $str = "UPDATE " . _DB_PF_ . _USER_TABLE_ . " SET last_login = now() WHERE id = ?";
                $db->update($str, array($CRD['id']));

                $str = "SELECT DATE_FORMAT(last_login, '%Y/%m/%d %k:%i') AS last_login FROM " . _DB_PF_ . _USER_TABLE_ . " WHERE id = ?";
                $LL = $db->query($str, array($CRD['id']))->fetch();

                $_SESSION[_SESS_MY_KEY_]['last_login'] = $LL['last_login'];

                return $_SESSION[_SESS_MY_KEY_][_LANG_NAME_];
            } else {
                $this->showLogin($view, $loginerror[_DEFAULT_LANG_]);
            }
        } else {
            $this->showLogin($view);
        }
    }

    public function showLogin(&$view, $message = '') {
        $view->assign('system_name', _SYSTEM_NAME_);
        $view->assign('base_path', _MY_PATH_);
        $view->assign('timestamp', time());
        $view->assign('message', $message);
        if (isset($_POST[_USERNAME_NAME_])) {
            $view->assign(_USERNAME_NAME_, $_POST[_USERNAME_NAME_]);
        } else {
            $view->assign(_USERNAME_NAME_, "");
        }
        if (isset($_POST[_PASS_NAME_])) {
            $view->assign(_PASS_NAME_, $_POST[_PASS_NAME_]);
        } else {
            $view->assign(_PASS_NAME_, "");
        }

        try {

            $view->display(_MY_DIR_ . _DEFAULT_LANG_ . _DS_ . 'login.' . _TPL_EXT_);
            exit;
        } catch (SmartyException $e) {
            q4mSystem::haltOnError($e->getMessage(), get_class($this) . '::' . $this->default_method, __FILE__, __LINE__);
            exit;
        }
    }

}

?>