<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelChambre.php'));
require_once File::build_path(array('model', 'ModelVisuelChambre.php'));


class ControllerAdmin {
	protected static $object = 'admin';

	// Charge l'index de l'administration
	public static function index() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);
			$view = 'index';
			$pagetitle = 'Administration';
			$template = 'admin';
			require File::build_path(array('view', 'main_view.php'));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function update_url(){
		$view = 'displayChambre';
		$pagetitle = 'detail de la chambre';

		$powerNeeded = true;
		require_once File::build_path(array("view","main_view.php"));
	}

	public static function chambres() {
		if(ControllerUtilisateur::isConnected()) {
			$currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
			$powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);
			
			$view = 'listChambres';
			$pagetitle = 'Administration - Liste des chambres';
			$template = 'admin';
			$tab_chambres = ModelChambre::selectAll();
			require_once File::build_path(array("view","main_view.php"));
		} else {
			ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
		}
	}

	public static function editChambre() {
		// Attend un $_GET['idChambre']
	}

	public static function deleteChambre() {
		// Attend un $_GET['idChambre']
	}

	public static function managePrestations() {
		// Attend un $_GET['idChambre']
	}

	public static function manageDetails() {
		// Attend un $_GET['idChambre']
	}
}
?>