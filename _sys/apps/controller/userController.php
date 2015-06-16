<?php

class userController extends q4mController {

    public function beforeAction() {

        $this->useDB(true);
        $this->useAuth(true);
        $this->chekCredential();
    }

    protected function chekCredential() {

        if (isset($_SESSION[_SESS_MY_KEY_]['admin']) && $_SESSION[_SESS_MY_KEY_]['admin'] != 1) {

            $this->logOut();
        }
    }

    public function beforeDisplay() {
        $this->view->assign('loginuser', $_SESSION[_SESS_MY_KEY_]['name']);
        $this->view->assign('loginstart', $_SESSION[_SESS_MY_KEY_]['last_login']);
        $this->view->assign('is_admin', $_SESSION[_SESS_MY_KEY_]['admin']);
    }

    protected function index() {

        $model = $this->useModel($this->db);
        $USERS = $model->getUserList();
        $PREFS = $model->getPrefList();
        $this->view->assign('staffs', $USERS);
        $this->view->assign('prefs', $PREFS);

        $this->display('index', 'user');

        exit;
    }

    protected function showDetail($param) {

        $ids = explode('_', $param);
        $model = $this->useModel($this->db);

        $detail = $model->getDetail($ids[1]);
        $this->view->assign('update_list', 1);
        $this->view->assign('error', 0);

        $this->view->assign($detail);
        $this->display();
        ;

        exit;
    }

    protected function edit() {
        if (isset($_POST['id'])) {
            $mode = "edit";
        } else {
            $mode = "new";
        }
        
        $model = $this->useModel($this->db);
        $shopModel = $this->useModel($this->db, 'shop');
        if ($mode == "edit") {
            $detail = $model->getDetail($_POST['id']);
            $PREFS = $model->getPrefList($detail['pref']);
            $SHOPS = $shopModel->getShopList($detail['pref'], $detail['shop_code']);
        } else {
            $PREFS = $model->getPrefList();
            $SHOPS = array();
        }
        
        $this->view->assign("mode", $mode);
        $this->view->assign('prefs', $PREFS);
        $this->view->assign('shops', $SHOPS);
        if (isset($detail)) {
            $this->view->assign($detail);
        }
        $this->view->assign('update_list', 1);
        $this->view->assign('error', 0);
        $this->display('edit', 'user');

        exit;
    }

    protected function userSave($mode) {

        $this->useHelper('q4mSecurity');
        q4mSecurity::sanitize($_POST);

        $model = $this->useModel($this->db);

        if ($mode == 'edit' && $_POST['id'] != '') {

            $id = $model->nameCheck($_POST['username']);

            if ($id['id'] && $id['id'] != $_POST['id']) {
                $this->view->assign('error', $this->lang_data['username_taken_error']);
                $this->view->assign('mode', $mode);
                $this->showFormError();
            }

            $model->updateUser();

            $detail = $model->getDetail($_POST['id']);

            $this->view->assign($detail);
            $this->view->assign('update_list', 1);
            $this->view->assign('mode', $mode);
            $this->view->assign('error', 0);
            $this->display('showDetail');

            exit;
        } else if ($mode == 'new' && $_POST['id'] == '') {

            $id = $model->nameCheck($_POST['username']);

            if ($id) {
                $this->view->assign('error', 'username_taken_error');
                $this->view->assign('mode', $mode);
                $this->showFormError();
            }

            $id = $model->saveUser();

            $detail = $model->getDetail($id);

            $this->view->assign($detail);
            $this->view->assign('update_list', 1);
            $this->view->assign('mode', $mode);
            $this->view->assign('error', 0);
            $this->display('showDetail');
        } else {
            $this->view->assign('update_list', 0);
            $this->view->assign('error', $this->lang_data['nomode_error']);
            $this->showFormError();
        }

        exit;
    }

    protected function showFormError() {

        $this->view->assign($_POST);
        $this->view->assign('update_list', 0);
        $this->display('showNew', 'showNew');
        exit;
    }

    protected function showUserList() {

        $model = $this->useModel($this->db);

        $USERS = $model->getUserList();

        $model->db->close();


        $this->view->assign('id', $_SESSION[_SESS_MY_KEY_]['id']);
        $this->view->assign('users_set', $USERS);

        $this->display();

        exit;
    }

    protected function deleteUser($id) {
        $this->useHelper('q4mSecurity');
        q4mSecurity::sanitize($_POST);

        $model = $this->useModel($this->db);

        $model->deleteuser($id);

        $this->template = 'showUserList';

        $this->showUserList();
    }

}

?>