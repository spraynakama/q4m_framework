<?php

class q4mSecurity {

  public function sanitize(&$INPUT) {
    
    if (is_array($INPUT)) {
      $NEW = array();
      if (count($INPUT)) {
        foreach ($INPUT as $key => $val) {
          $clean_key = htmlspecialchars($key);
          if (is_array($INPUT[$key])) {

            foreach ($INPUT[$key] as $key2 => $value2) {
              $clean_key2 = htmlspecialchars($key2);
              unset($INPUT[$key][$key2]);
              $value2 = str_ireplace(array('delete', 'truncate', 'select', ';', '='), array('', '', '', '&#059;', '&#061;'), $value2);
              $NEW[$clean_key][$clean_key2] = q4mSecurity::killJS(htmlspecialchars($value2));
            }
          } else {
            unset($INPUT[$key]);
              $val = str_ireplace(array('delete', 'truncate', 'select', ';', '='), array('', '', '', '&#059;', '&#061;'), $val);
             
              $NEW[$clean_key] = q4mSecurity::killJS(htmlspecialchars($val));//無限ループ

          }
        }
      }
      $INPUT = $NEW;
    } else {
      $INPUT = str_ireplace(array('delete', 'truncate', 'select', ';', '='), array('', '', '', '&#059;', '&#061;'), $INPUT);
      $INPUT = q4mSecurity::killJS(htmlspecialchars($INPUT));
    }
  }

  public function killJS($str = null) {

    if ($str == '') {
      return;
    }
    $str = str_replace("\n\n", '<br />', $str);
    $str = str_replace("\r", '<br />', $str);
    $str = preg_replace('/\<.*script.*\>(.*)\<.*\/.*script.*\>/i', '${1}', $str);

    return $str;
  }

}

?>