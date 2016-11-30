<?php
	if(!isset($template)) {
		$template = Conf::$theme;
	}

	if(file_exists(File::build_path(array('view', 'themes', $template, 'view.php')))) {
		require_once File::build_path(array("view", 'themes', $template, "view.php"));
	}
?>