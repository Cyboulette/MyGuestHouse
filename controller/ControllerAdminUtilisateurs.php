<?php 
	class ControllerAdminUtilisateurs extends ControllerAdmin {

		public static function utilisateurs($message = null) {
			$powerNeeded = self::isAdmin();
			$view = 'listUsers';
			$pagetitle = 'Administration - Liste des utilisateurs';
			$template = 'admin';

			if(isset($rang) && $rang!=null){
				switch ($rang) {
		            case 'admin': $tab_utilisateurs = ModelUtilisateur::selectAll(); break;
		            case 'membre': $tab_utilisateurs = ModelUtilisateur::selectAll(); break;
		            case 'visiteur': $tab_utilisateurs = ModelUtilisateur::selectAll(); break;
		            case 'all': $tab_utilisateurs = ModelUtilisateur::selectAll(); break;
		            case 'nonValide': $tab_utilisateurs = ModelUtilisateur::selectAll(); break;
		            default: $tab_utilisateurs = ModelUtilisateur::selectAll(); $rang='membre'; break;
        		}
			}else{
				$rang='admin';
				$tab_utilisateurs = ModelUtilisateur::selectAll();
			}
			require_once File::build_path(array("view","main_view.php"));
		}
	}
?>