<?php

class userModel extends q4mModel {
    
    var $PREF = array(
        1 => "北海道",
        4 => "宮城",
        11 => "埼玉",
        12 => "千葉",
        13 => "東京",
        14 => "神奈川",
        15 => "新潟",
        21 => "岐阜",
        23 => "愛知",
        24 => "三重",
        26 => "京都",
        27 => "大阪",
        28 => "兵庫",
        34 => "広島",
        40 => "福岡",
        42 => "長崎",
        43 => "熊本",
        44 => "大分");

    public function getUserList() {

        $str = "SELECT u.id, u.staff_code, s.pref as pref_code, u.name, u.loginname, u.password, u.admin, u.shop_code, s.name as shop, u.on_off "
                . " , DATE_FORMAT(last_login, '\'%y/%m/%d %H:%i') AS last_login FROM " . _DB_PF_ . _USER_TABLE_ . " as u "
                . " LEFT OUTER JOIN " . _DB_PF_ . "shop as s on u.shop_code = s.shop_code ORDER BY s.pref, u.shop_code, u.id ";

        $res = $this->db->query($str)->fetchAll();
        foreach ($res as $key => $val) {
            $res[$key]['pref'] = $this->PREF[$val['pref_code']];
        }
        
        return $res;
    }

    public function getPrefList($id = null) {
        $PREFS = array();
                
        foreach ($this->PREF as $key => $val) {
            if ($key == $id) {
               $selected = 1; 
            } else {
               $selected = 0;
            }
            $PREFS[] = array('id' => $key, 'name' => $val, 'selected' => $selected);
        }
        
        return $PREFS;
    }
    
    public function getDetail($id) {

        $str = "SELECT u.*, s.pref, DATE_FORMAT(last_login, '\'%y/%m/%d %H:%i') AS last_login "
                . " FROM " . _DB_PF_ . _USER_TABLE_ . " as u,"
                . _DB_PF_ . "shop as s WHERE u.id = ? and s.shop_code = u.shop_code";
        return $this->db->query($str, array($id))->fetch();
    }

    public function updateUser() {

        $str = "UPDATE " . _DB_PF_ . _USER_TABLE_ . " SET username = ?, displayname = ?, password = ?, user_lang = ? WHERE id = ? ";

        $this->db->update($str, array($_POST['username'], $_POST['displayname'], sha1($_POST['password']), $_POST['user_lang'], $_POST['id']));
        return;
    }

    public function saveUser() {

        $str = "INSERT INTO " . _DB_PF_ . _USER_TABLE_ . " (username, displayname, password, user_lang) VALUES (?, ?, ?, ?) ";

        $id = $this->db->update($str, array($_POST['username'], $_POST['displayname'], sha1($_POST['password']), $_POST['user_lang']), 'id');

        return $id;
    }

    public function deleteUser($id) {

        $str = "DELETE FROM " . _DB_PF_ . _USER_TABLE_ . " WHERE id = ? ";

        $this->db->query($str, array($id));
    }

    public function nameCheck($name) {

        $str = "SELECT id FROM " . _DB_PF_ . _USER_TABLE_ . " WHERE username = ?";

        return $this->db->query($str, array($name))->fetch();
    }

}

?>