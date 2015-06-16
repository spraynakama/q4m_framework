<?php
include_once("define.php");

set_include_path(get_include_path() . PATH_SEPARATOR . _SYS_DIR_ ); 
include_once(_INIT_);

q4mSystem::kaboom();

exit;

?>