<?php

	class dataSource {
		
		var $dc = null;
		
		public function getDataSource($datasource, $setting) {
				
				
				include_once(_DC_DIR_ . 'class.' . $datasource . '.php');

				include(_SETTINGS_DIR_ . $setting . '.php');

				return $dc = new $datasource($db_type, $db_host, $db_name, $db_user, $db_pass, $charset);

		}
		
	}

?>