<?php

class indexController extends q4mController {

    public function beforeAction() {

        $this->useHelper('q4mSecurity');
        q4mSecurity::sanitize($_POST);

        if (isset($_POST['logout'])) {

            if ($_POST['logout'] == 1) {
                $this->logOut();
            }
        }
        $this->useDB(true);
        $this->useAuth(true);
    }

    public function beforeDisplay() {

        $this->view->assign('loginuser', $_SESSION[_SESS_MY_KEY_]['name']);
        $this->view->assign('loginstart', $_SESSION[_SESS_MY_KEY_]['last_login']);
        $this->view->assign('is_admin', $_SESSION[_SESS_MY_KEY_]['admin']);
    }

    protected function index() {

        $this->view->assign('id', $_SESSION[_SESS_MY_KEY_]['id']);
        $this->display();

        exit;
    }

    protected function showList() {
        $this->display();
        exit;
    }

    protected function showBlock() {
        $this->display();
        exit;
    }
    protected function test() {

        $this->display();

        exit;
    }

}

?>