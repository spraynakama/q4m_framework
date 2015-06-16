<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itemModel
 *
 * @author nakama
 */
class itemsModel extends q4mModel {

    //put your code here

    public function getCategories() {
        $str = "select * from " . _DB_PF_ . "product_category order by priority";
        $res = $this->db->query($str)->fetchAll();
        return $res;
    }

    public function getProductsByCategory($category, $from = 1, $limit = _LIMIT_) {

        $start = ($from - 1) * $limit;
        $str = "select * from " . _DB_PF_ . "products where category = ? "
                . " order by priority"
                . " limit " . $start . ", " . $limit;
        $res = $this->db->query($str, array($category))->fetchAll();
        return $this->checkPictures($res);
    }

    public function search($searchword = '', $category = '',  $from = 1, $limit = _LIMIT_){
        
        $start = ($from - 1) * $limit;
        $str = "select * ";
        $cond = $this->getSearchString($searchword, $category);
        
        $str .= $cond['str']
                . " order by priority"
                . " limit " . $start . ", " . $limit;
        
        $res = $this->db->query($str, $cond['cond'])->fetchAll();
        return $this->checkPictures($res);
        
    }
    
    public function getTotalCountBySearch($searchword = '', $category = '') {
        
        $str = "select count(id) as count ";
        $cond = $this->getSearchString($searchword, $category);
        
        $str .= $cond['str'];
        //print $str;
        //var_dump($cond['cond']);
        $res = $this->db->query($str, $cond['cond'])->fetch();
        return $res['count'];
    }
    
    public function getSearchString($searchword = '', $category = '') {
        $cond[] = array();
        $wordstr = '';
        if ($searchword) {
            $word = str_replace(' ', ',', $searchword);
            $words = explode(',', $word);
            foreach ($words as $key => $w) {
                $snapets[] = " name like '%" . $w . "%' or description like '%" . $w . "%' ";
            }
            $wordstr = " (" . implode(" or ", $snapets) . ") ";
            
        }
        
        $catstr = '';
        $cond = array();
        if (isset($category)) {
            $catstr = " category = ? ";
            $cond[] = $category;
        }
        
        $str = " from " . _DB_PF_ . "products ";
        
        if (strlen($wordstr)) {
            $str .= ' where ' . $wordstr;
        }
        if (strlen($catstr)) {
            if (!strlen($wordstr)) {
                $str .= " where ";
            } else {
                $str .= " and ";
            }
            $str .= $catstr;
        }
        
        return array('str' => $str, 'cond' => $cond);
        
        
    }
    
    public function checkPictures($list) {
        $products_dir = _BASE_DIR_ . 'products' . _DS_;
        foreach ($list as $key => $p) {
            $pic_sx = $products_dir . $p['id'] . '_sx.jpg';
            $pic_s = $products_dir . $p['id'] . '_s.jpg';
            $pic_m = $products_dir . $p['id'] . '_m.jpg';
            $pic_l = $products_dir . $p['id'] . '_l.jpg';
            $list[$key]['pic_sx'] = (file_exists($pic_sx)) ? $p['id'] . '_sx.jpg' : 'no_pic.png';
            $list[$key]['pic_s'] = (file_exists($pic_s)) ? $p['id'] . '_s.jpg' : 'no_pic.png';
            $list[$key]['pic_m'] = (file_exists($pic_m)) ? $p['id'] . '_m.jpg' : 'no_pic.png';
            $list[$key]['pic_l'] = (file_exists($pic_l)) ? $p['id'] . '_l.jpg' : 'no_pic.png';
        }

        return $list;
    }

    public function getTotalCountByCategory($category = 0) {
        $str = "select count(id) as count from " . _DB_PF_ . "products where category = ? ";
        $res = $this->db->query($str, array($category))->fetch();
        return $res['count'];
    }

    public function makePaging($category = 0, $from = 0, $total, $limit) {

        require_once("Pager/Pager.php");

        $options = array(
            "mode" => 'Sliding',
            "totalItems" => $total,
            "delta" => 10,
            "currentPage" => $from,
            "perPage" => $limit,
            "append" => false,
            "path" => '',
            "fileName" => 'JavaScript:nextPage(%d, ' . $category . ');',
            "prevImg" => '<span class="glyphicon glyphicon-backward"></span>',
            "nextImg" => '<span class="glyphicon glyphicon-forward"></span>',
            "firstPageText" => '<span class="glyphicon glyphicon-fast-backward"></span>',
            "firstPagePre" => "&nbsp;",
            "firstPagePost" => "&nbsp;",
            "lastPageText" => '<span class="glyphicon glyphicon-fast-forward"></span>',
            "lastPagePre" => "",
            "lastPagePost" => "",
            "separator" => "</li><li>",
            "curPageSpanPre" => '<a href="#" class="curPage"><strong>',
            "curPageSpanPost" => '</strong></a>',
            "spacesBeforeSeparator" => 0,
            "spacesAfterSeparator" => 0
        );
        $pager = Pager::factory($options);
        $navi = $pager->getLinks();
        $str = $navi["all"];
        return $str;
    }

}
