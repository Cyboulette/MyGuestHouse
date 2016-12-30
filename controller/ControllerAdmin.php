<?php 
	class ControllerAdmin {
		protected static $object = 'admin';

	    public static function isAdmin() {
	        if(ControllerUtilisateur::isConnected()) {
	            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
	            if($currentUser->getPower() != Conf::$power['admin']) {
	                ControllerDefault::error('Vous ne possédez pas les droits pour accéder à cette page !');
	                exit();
	            } else {
	                return true;
	            }
	        } else {
	            ControllerDefault::error('Vous devez être connecté pour accéder à l\'administration');
	            exit();
	        }
	    }

	    public static function index() {
			$powerNeeded = self::isAdmin();
			$view = 'index';
			$pagetitle = 'Administration';
			$template = 'admin';
			require File::build_path(array('view', 'main_view.php'));
		}

		public static function help(){
			$powerNeeded = self::isAdmin();
			$view = 'help';
			$pagetitle = 'Administration';
			$template = 'admin';
			require File::build_path(array('view', 'main_view.php'));
		}
	}
?>