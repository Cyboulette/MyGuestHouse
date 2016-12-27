<?php 
	class ControllerAdminUtilisateurs extends ControllerAdmin {

		public static function utilisateurs($message = null) {
			$powerNeeded = self::isAdmin();
			$view = 'listUsers';
			$pagetitle = 'Administration - Liste des utilisateurs';
			$template = 'admin';

			if(isset($_GET['mode']) && $_GET['mode']!=null){
				switch ($_GET['mode']) {
		            case 'admin': $tab_utilisateurs = ModelUtilisateur::selectByRang('3'); $mode='membre'; break;
		            case 'membre': $tab_utilisateurs = ModelUtilisateur::selectByRang('2'); $mode='membre'; break;
		            case 'visiteur': $tab_utilisateurs = ModelUtilisateur::selectByRang('1'); $mode='membre'; break;
		            case 'all': $tab_utilisateurs = ModelUtilisateur::selectAll(); $mode='all'; break;
		            case 'nonValide': $tab_utilisateurs = ModelUtilisateur::selectNonValide(); $mode='membre'; break;
		            default: $tab_utilisateurs = ModelUtilisateur::selectAll(); $mode='membre'; break;
        		}
			}else{
				$mode='all';
				$tab_utilisateurs = ModelUtilisateur::selectAll();
			}
			require_once File::build_path(array("view","main_view.php"));
		}
	}
?>