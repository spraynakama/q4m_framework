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

        $this->view->assign('loginname', $_SESSION[_SESS_MY_KEY_]['displayname']);
        $this->view->assign('loginstart', $_SESSION[_SESS_MY_KEY_]['last_login']);
    }

    protected function index() {

        $this->view->assign('id', $_SESSION[_SESS_MY_KEY_]['id']);
        $this->display();

        exit;
    }

    protected function test() {

        $this->display();

        exit;
    }

}

?>