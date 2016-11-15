<?php 

	class ControllerAdmin {
		protected static $object = 'admin';

		// Charge l'index de l'administration
		public static function index() {
			$view = 'index';
			$pagetitle = 'Administration';
			$template = 'admin';
			require File::build_path(array('view', 'main_view.php'));
		}
	}
?>