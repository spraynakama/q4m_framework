<?php
/**
 * 
 * @param type $param array | string
 * $param['message'] can be a single string or array of strings
 * @param type $smarty $smarty object
 * @return type string
 * {configVars message=$message glue=$glue}
 */
function smarty_function_configvars($param, &$smarty)
{
  if (!isset($param['message'])) {
    return;
  }
  if (is_array($param['message'])) {
    $mess = array();
    foreach($param['message'] as $key => $val) {
      $mess[] = $smarty->getConfigVars($val);
    }
    
    $glue = (!isset($param['glue'])) ? '<br />' : $param['glue'];

    return implode($glue, $mess);
  } else {
    return $smarty->getConfigVars($param['message']);
  }
  
} 

?>