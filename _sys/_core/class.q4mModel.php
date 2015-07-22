<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author hnakama
 */
class q4mModel {

//put your code here
  public $db = null;

  public function __construct(&$db) {
    $this->db = $db;
  }

  public function validate($file = '', $rule = '', $encode = 'utf8', $VAL = null) {

    q4mController::useHelper('validator');

    if ($file == '') {
      $file = str_replace('Model', '', get_class($this)) . 'Rules.php';
    }
    if ($rule == '') {
      $rule = str_replace('Model', '', get_class($this));
    }

    if (file_exists(_SYS_DIR_ . _SETTINGS_DIR_ . $file . 'Rules.php')) {

      include_once(_SETTINGS_DIR_ . $file . 'Rules.php');

      if (!isset($$rule) || !count($$rule)) {
        q4mSystem::haltOnError('The requested rule "' . $$rule . '" is empty in ', _SYS_DIR_ . _SETTINGS_DIR_ . $file . 'Rules.php', __FILE__, __LINE__);
        exit;
      }
    } else {
      q4mSystem::haltOnError('The file is not found', _SYS_DIR_ . _SETTINGS_DIR_ . $file . 'Rules.php', __FILE__, __LINE__);
      exit;
    }
    $rules = $$rule;

    $vc = new validator($rules, $encode, $VAL);

    if (count($vc->RULES)) {
      foreach ($vc->RULES as $key => $SV) {
        $vc->validate($key);
      }
    }

    if (count($vc->ERRORS)) {
      return $vc->ERRORS;
    } else {
      return false;
    }
  }

  function makeErrorList($ERRORS) {
    if (!count($ERRORS)) {
      return;
    }
    $statement = array();

    foreach ($ERRORS as $key => $ERROR) {
      foreach ($ERROR as $K => $v) {
        $statement[] = $v;
      }
    }
    return $statement;
  }

  public function deploy($table) {
    $cstr = "desc " . _DB_PF_ . $table;
    $fields = array();
    $qs = array();
    $res = $this->db->query($cstr)->fetchAll();
    foreach ($res as $key => $field) {
      $fields[] = $field['Field'];
      $qs[] = '?';
    }
    $filed_str = implode(', ', $fields);
    $qs_str = implode(', ', $qs);

    $str = "select * from  " . _DB_PF_ . $table;

    $in_str = "insert into " . _DB_PF_ . $table . "_dep";
    $in_str .= " (" . $filed_str . ") ";
    $in_str .= " values (" . $qs_str . ")";

    $del_str = "truncate " . _DB_PF_ . $table . "_dep";
    $this->db->update($del_str);

    $menus = $this->db->query($str)->fetchAll();

    foreach ($menus as $key => $RES) {
      $INS = array();
      foreach ($RES as $inKey => $value) {
        array_push($INS, $value);
      }
      //var_dump($INS);
      $this->db->update($in_str, $INS);
    }
  }

  public function makePaging($total, $from = null) {
    if (!isset($from)) {
      $from = 0;
    }
    require_once("Pager/Pager.php");
    $options = array(
        "mode" => 'Sliding',
        "totalItems" => $total,
        "delta" => 5,
        "currentPage" => $from,
        "perPage" => _LIMIT_,
        "append" => false,
        "path" => '',
        "fileName" => '#" data-page="%d" class="page_link',
        "prevImg" => '<span class="glyphicon glyphicon-chevron-left"></span>',
        "nextImg" => '<span class="glyphicon glyphicon-chevron-right"></span>',
        "firstPagePre" => "",
        "firstPagePost" => "<li>",
        "lastPagePre" => "",
        "lastPagePost" => "</li>",
        "separator" => '</li><li>',
        "curPageSpanPre" => '<a href="#" class="active">',
        "curPageSpanPost" => '</a>',
        "spacesBeforeSeparator" => 0,
        "spacesAfterSeparator" => 0
    );
    $pager = Pager::factory($options);
    $navi = $pager->getLinks();
    $str = '<li>' . $navi["all"] . '</li>';
    $str = str_replace('&quot;', '"', $str);
    $str = str_replace('<li><a href="#" class="active">', '<li class="active"><a href="#">', $str);
    return $str;
  }

}
