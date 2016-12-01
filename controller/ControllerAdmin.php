<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelChambre.php'));
require_once File::build_path(array('model', 'ModelVisuelChambre.php'));


class ControllerAdmin {
	protected static $object = 'admin';

	// Charge l'index de l'administration
	public static function index() {
		$powerNeeded = true;
		$view = 'index';
		$pagetitle = 'Administration';
		$template = 'admin';
		require File::build_path(array('view', 'main_view.php'));
	}

	public static function update_url(){
		$view = 'displayChambre';
		$pagetitle = 'detail de la chambre';

		$powerNeeded = true;
		require_once File::build_path(array("view","main_view.php"));
	}
}
?>