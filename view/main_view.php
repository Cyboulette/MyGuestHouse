<?php
	$websiteName = (!empty(ModelOption::selectCustom('nameOption', 'nom_site')[0]->get('valueOption')) ? ModelOption::selectCustom('nameOption', 'nom_site')[0]->get('valueOption'):'Nom de votre site');
	$customColor = (!empty(ModelOption::selectCustom('nameOption', 'main_color_site')[0]->get('valueOption')) ? ModelOption::selectCustom('nameOption', 'main_color_site')[0]->get('valueOption'):'#ad1717');
	$customBorder = ControllerDefault::ColorDarken($customColor, 50);
	Conf::$theme = (!empty(ModelOption::selectCustom('nameOption', 'theme_site')[0]->get('valueOption')) ? ModelOption::selectCustom('nameOption', 'theme_site')[0]->get('valueOption'):'default');
	
	if(!isset($template)) {
		$template = Conf::$theme;
	}

	if(file_exists(File::build_path(array('view', 'themes', $template, 'view.php')))) {
		require_once File::build_path(array("view", 'themes', $template, "view.php"));
	}
?>