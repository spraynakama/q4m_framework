<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shoModel
 *
 * @author hnakama
 */
class shopModel extends q4mModel{
    //put your code here
    
    public function getShopList($pref = null, $shop_code = null) {
        $str = "select * from " . _DB_PF_ . "shop where pref = ? order by shop_code";
       
        $res = $this->db->query($str, array($pref))->fetchAll();
        
        foreach ($res as $key => $val) {
            if (isset($shop_code) && $val['shop_code'] == $shop_code) {
                $res[$key]['selected'] = 1;
            } else {
                $res[$key]['selected'] = 0;
            }
        }
        
        return $res;
       
    }
}
