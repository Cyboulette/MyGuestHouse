<?php 
	class ControllerAdminUtilisateurs extends ControllerAdmin {

		public static function utilisateurs($message = null) {
			$powerNeeded = self::isAdmin();
			$view = 'listUsers';
			$pagetitle = 'Administration - Liste des utilisateurs';
			$template = 'admin';

			if(isset($_GET['mode']) && $_GET['mode']!=null){
				switch ($_GET['mode']) {
		            case 'admin': $tab_utilisateurs = ModelUtilisateur::selectCustom('rang', '3'); $mode='admin'; break;
		            case 'membre': $tab_utilisateurs = ModelUtilisateur::selectCustom('rang', '2'); $mode='membre'; break;
		            case 'visiteur': $tab_utilisateurs = ModelUtilisateur::selectCustom('rang', '1'); $mode='visiteur'; break;
		            case 'all': $tab_utilisateurs = ModelUtilisateur::selectAll(); $mode='all'; break;
		            case 'nonValide': $tab_utilisateurs = ModelUtilisateur::selectNonValide(); $mode='nonValide'; break;
		            default: $tab_utilisateurs = ModelUtilisateur::selectAll(); $mode='all'; break;
        		}
			}else{
				$mode='all';
				$tab_utilisateurs = ModelUtilisateur::selectAll();
			}
			require_once File::build_path(array("view","main_view.php"));
		}

		public static function read(){
			$powerNeeded = self::isAdmin();
			if(isset($_GET['idUtilisateur']) && $_GET['idUtilisateur']!=null){
				$utilisateur = ModelUtilisateur::select($_GET['idUtilisateur']);
				if($utilisateur!=false){
					$view = 'readUser';
					$pagetitle = 'Administration - un utilisateur';
					$template = 'admin';
					require_once File::build_path(array("view", "main_view.php"));
				}else{
					$message = '<div class="alert alert-danger">cet Utilisateur n\'existe plus !</div>';
					self::utilisateurs($message);
				}
			}else{
				$message = '<div class="alert alert-danger">Votre requette n\'a pas pu aboutire !</div>';
				self::utilisateurs($message);
			}
		}
	}
?>