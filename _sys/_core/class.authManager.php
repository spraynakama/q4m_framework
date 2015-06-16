<?php

class authManager {

    public function auth(&$view = null, &$db = null) {

        if (!file_exists(_SYS_DIR_ . _MY_DIR_ . 'auth_inc.php')) {
            q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _MY_DIR_ . 'auth_inc.php', __FILE__, __LINE__);
            exit;
        }

        include_once(_MY_DIR_ . 'auth_inc.php');
        
        if (!isset($_SESSION[_SESS_MY_KEY_][_USERNAME_])) {

            if (!file_exists(_SYS_DIR_ . _HELPER_DIR_ . 'class.' . _AUTH_TYPE_ . '.php')) {
                q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _HELPER_DIR_ . 'class.' . _AUTH_TYPE_ . '.php', __FILE__, __LINE__);
                exit;
            }

            include_once(_HELPER_DIR_ . 'class.' . _AUTH_TYPE_ . '.php');

            $authclass = _AUTH_TYPE_;
            $authmodel = new $authclass($auth_datasource);
            $authmodel->auth($view, $SESSINFO, $db, $loginerror);
        }
        return $_SESSION[_SESS_MY_KEY_][_LANG_NAME_];
    }

    public function logOut(&$view) {

        $_SESSION[_SESS_MY_KEY_] = array();
        if (!file_exists(_SYS_DIR_ . _MY_DIR_ . 'auth_inc.php')) {
            q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _MY_DIR_ . 'auth_inc.php', __FILE__, __LINE__);
            exit;
        }

        include_once(_MY_DIR_ . 'auth_inc.php');

        if (!file_exists(_SYS_DIR_ . _HELPER_DIR_ . 'class.' . _AUTH_TYPE_ . '.php')) {
            q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _HELPER_DIR_ . 'class.' . _AUTH_TYPE_ . '.php', __FILE__, __LINE__);
            exit;
        }

        include_once(_HELPER_DIR_ . 'class.' . _AUTH_TYPE_ . '.php');

        $authclass = _AUTH_TYPE_;
        $authmodel = new $authclass();
        $authmodel->showLogin($view);
    }

}

?>