<?php

class orderController extends q4mController {

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
        $this->display('new_order');

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
    protected function orderList() {

        $this->view->assign('code', '12345');
        $this->display('order_history');

        exit;
    }
    
    protected function historyList($mode) {
        $template = 'history_' . $mode;
        if ($mode == 'comp') {
            $code = '12346';
        } else {
            $code = '12345';
        }
        $this->view->assign('code', $code);
        $this->display($template);
        exit;
    }
    
    protected function history($code) {
        
        $this->view->assign('code', $code);
        if ($code == '012345' || $code == '012344') {
            $template = 'list_out';
        } else {
            $template = 'list_comp';
        }
        $this->display($template);
        exit;
        
    }
    
    protected function historyStatus($code) {

        if ($code == '012345' || $code == '012344') {
            $template = 'status_out';
        } else {
            $template = 'status_comp';
        } 
        $this->display($template);
        exit;
    }

}

?>