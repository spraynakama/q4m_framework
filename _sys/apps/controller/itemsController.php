<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itemsController
 *
 * @author nakama
 */
class itemsController extends q4mController {

    public function beforeAction() {

        $this->useHelper('q4mSecurity');
        q4mSecurity::sanitize($_POST);

        $this->useDB(true);
        $this->useAuth(true);
        if (isset($_POST['parpage'])) {
            $_SESSION[_SESS_MY_KEY_]['limit'] = $_POST['parpage'];
        } else if (!isset($_SESSION[_SESS_MY_KEY_]['limit'])){
            $_SESSION[_SESS_MY_KEY_]['limit'] = _LIMIT_;
        } 
    }

    public function index() {
        $model = $this->useModel($this->db);
        $categories = $model->getCategories();
       
        $this->view->assign('categories', $categories);

        $this->display();
    }

    public function beforeDisplay() {

        $this->view->assign('loginname', $_SESSION[_SESS_MY_KEY_]['displayname']);
        $this->view->assign('loginstart', $_SESSION[_SESS_MY_KEY_]['last_login']);
    }

    protected function detail($no) {

        $this->display();
    }

    public function showList() {
        $this->display('favoriteList');
    }

    public function showBlock() {
        $this->display();
    }
    
    public function itemList() {
        $model = $this->useModel($this->db);
        $categories = $model->getCategories();
       
        $this->view->assign('categories', $categories);
        $this->display();
    }
    
    public function search() {
        $_SESSION[_SESS_MY_KEY_]['last_action'] = 'search';
        $_SESSION[_SESS_MY_KEY_]['last_query'] = $_POST;
        
        if (isset($_POST['from'])) {
            $from = $_POST['from'];
        } else {
            $from = 1;
        }
        $start = ($from - 1) * $_SESSION[_SESS_MY_KEY_]['limit'] + 1;
        $till = ($from - 1) * $_SESSION[_SESS_MY_KEY_]['limit'] + $_SESSION[_SESS_MY_KEY_]['limit'] ;
        $model = $this->useModel($this->db);
        $total = $model->getTotalCountBySearch(
                $_SESSION[_SESS_MY_KEY_]['last_query']['searchword'],
                $_SESSION[_SESS_MY_KEY_]['last_query']['category']);
        
        $till = ($till > $total) ? $total: $till;
        $products = $model->search(
                $_SESSION[_SESS_MY_KEY_]['last_query']['searchword'],
                $_SESSION[_SESS_MY_KEY_]['last_query']['category'], 
                $from, $_SESSION[_SESS_MY_KEY_]['limit']);
        $paging = $model->makePaging( $_SESSION[_SESS_MY_KEY_]['last_query']['category'], 
                $from, $total, $_SESSION[_SESS_MY_KEY_]['limit']);
        $this->view->assign('from', $start);
        $this->view->assign('till', $till);
        $this->view->assign('total', $total);
        $this->view->assign('products', $products);
        $this->view->assign('paging', $paging);
        $this->display('showList');
        
    }
    
    public function changeLimit() {
        
        if (isset($_SESSION[_SESS_MY_KEY_]['last_action'])) {
            if ($_SESSION[_SESS_MY_KEY_]['last_action'] == 'showByCategory') {
                $this->showByCategory($_SESSION[_SESS_MY_KEY_]['last_category']);
            } else if ($_SESSION[_SESS_MY_KEY_]['last_action'] == 'search') {
                $_POST = $_SESSION[_SESS_MY_KEY_]['last_query'];
                $this->showByCategory($_SESSION[_SESS_MY_KEY_]['search']);
            } 
        } else {
            print "";
        }
    }
    
    public function showByCategory($category) {
        $_SESSION[_SESS_MY_KEY_]['last_action'] = 'showByCategory';
        $_SESSION[_SESS_MY_KEY_]['last_category'] = $category;
        
        if (isset($_POST['from'])) {
            $from = $_POST['from'];
        } else {
            $from = 1;
        }
        $start = ($from - 1) * $_SESSION[_SESS_MY_KEY_]['limit'] + 1;
        $till = ($from - 1) * $_SESSION[_SESS_MY_KEY_]['limit'] + $_SESSION[_SESS_MY_KEY_]['limit'] ;
        
        $model = $this->useModel($this->db);
        $total = $model->getTotalCountByCategory($category);
        $till = ($till > $total) ? $total: $till;
        $products = $model->getProductsByCategory($category, $from, $_SESSION[_SESS_MY_KEY_]['limit']);
        $paging = $model->makePaging($category, $from, $total, $_SESSION[_SESS_MY_KEY_]['limit']);
        $this->view->assign('from', $start);
        $this->view->assign('till', $till);
        $this->view->assign('total', $total);
        $this->view->assign('products', $products);
        $this->view->assign('paging', $paging);
        $this->display('showList');
    }
}
