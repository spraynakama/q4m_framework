<?php

/**
 * Core system class
 *
 * @author H. Nakama
 * @since PHP 5.3
 */
class q4mSystem {

    /**
     * Breaks donwn the REQUEST_URI and derives names of a controller, a method and its parameter.
     * If not specified, the defaults are: indexController, index() and an empty parameter.
     * GET is ignored here.  It's handled as usual php $_GET.
     * After setting these names, the method of the controller is triggered.
     * @param none
     * @return none
     * Should be called as a static function from q4m_index.php
     */
    public function kaboom() {

        $command = str_replace(dirname($_SERVER['PHP_SELF']) . "/", '', $_SERVER['REQUEST_URI']);
        $command = str_replace('?' . $_SERVER['QUERY_STRING'], '', $command);

        if (!strlen($command)) {

            $controller = 'indexController';
            $method = 'index';
        } else {
            $command = preg_replace("/^\//", "", $command);
            $commands = explode('/', $command);

            if (isset($commands[0]) && strlen($commands[0])) {
                $controller = preg_replace("/(.+)(\.[^.]+$)/", "$1", $commands[0]);
                $controller = $controller . 'Controller';
            } else {
                $controller = 'indexController';
            }
            
            if (isset($commands[1]) && strlen($commands[1])) {
                $method = preg_replace("/(.+)(\.[^.]+$)/", "$1", $commands[1]);
            } else {
                $method = 'index';
            }
        }

        if (file_exists(_CONTROLLER_DIR_ . $controller . '.php')) {
            include_once(_CONTROLLER_DIR_ . $controller . '.php');

            $controllerObj = new $controller();

            $controllerObj->setDefaultMethod($method);
            $controllerObj->setTemplate($method);
            if (isset($commands[2])) {
                $controllerObj->action($commands[2]);
            } else {
                $controllerObj->action();
            }
        } else {
            q4mSystem::haltOnError('The file can not be found', _CONTROLLER_DIR_ . $controller . '.php', __FILE__, __LINE__);
            exit;
        }
    }

    /**
     * Creates its own Smarty class and displays given errors.
     * Should be called as a static function.
     * @param $message1: a message title.
     * @param $message2: main message.
     * @param $file: file name from which this function is called.
     * @param $line: line number where this function is called.
     * @return none
     */
    public function haltOnError($message1 = '', $message2 = '', $file = '', $line = '') {

        chdir(_SYS_DIR_);
        require_once(_SMARTY_);
        $pageObj = new Smarty();
        $pageObj->template_dir = _TEMPLATES_;
        $pageObj->compile_dir = _TEMPLATES_C_;

        $pageObj->assign('system_name', _SYSTEM_NAME_);
        $pageObj->assign('base_path', _BASE_PATH_);

        if (ini_get('display_errors')) {
            $pageObj->assign('message1', $message1);
            $pageObj->assign('message2', $message2);
            $pageObj->assign('file', $file);
            $pageObj->assign('line', $line);
        } else {

            $pageObj->assign('message1', 'Halted on error');
            $pageObj->assign('message2', 'a detailed message can be obtained by switching on display_errors in ini.php');
        }

        $pageObj->display('_error.' . _TPL_EXT_);
        exit;
    }

}

?>