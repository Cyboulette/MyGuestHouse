<?php 
	if(!isset($template)) {
		$template = 'site';
	}

	if(file_exists(File::build_path(array('view', 'view_'.$template.'.php')))) {
		require_once File::build_path(array("view", "view_".$template.".php"));
	}
?>