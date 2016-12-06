<?php
	$websiteName = (!empty(ModelOption::selectCustom('nameOption', 'nom_site')[0]->get('valueOption')) ? ModelOption::selectCustom('nameOption', 'nom_site')[0]->get('valueOption'):'Nom de votre site');
	if(!isset($template)) {
		$template = Conf::$theme;
	}

	if(file_exists(File::build_path(array('view', 'themes', $template, 'view.php')))) {
		require_once File::build_path(array("view", 'themes', $template, "view.php"));
	}
?>