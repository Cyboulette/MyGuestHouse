<?php 
	class ControllerAdminThemes extends ControllerAdmin {

		public static function themes($message = NULL) {
			$powerNeeded = self::isAdmin();
			$view = 'listThemes';
			$pagetitle = 'Administration - Gestion des thèmes de votre site';
			$template = 'admin';
			$folders = scandir(File::build_path(array("view", "themes")));
			require_once File::build_path(array("view", "main_view.php"));
		}

		// Fonction qui gère le formulaire de confirmation de changement de theme
		public static function changeThemeForm() {
			self::isAdmin();
			$retour = array(); //Tableau de retour
			if(isset($_POST['nameTheme'])) {
				$nameTheme = htmlspecialchars($_POST['nameTheme']);
				$filePath = File::build_path(array('view', 'themes', $nameTheme, 'template.json'));
				if(file_exists($filePath)) {
					$form = '<form method="POST" role="form" action="index.php?controller=adminThemes&action=changeTheme">
						<div class="alert alert-info text-center">
							Confirmez vous le changement de thème vers le thème <b>'.$nameTheme.'</b> ?
						</div>
						<input type="hidden" name="nameTheme" value="'.$nameTheme.'">
						<input type="hidden" name="confirm" value="true">
						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmer</button>
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>
						</div>
					</form>';
					$retour['result'] = true;
					$retour['message'] = $form;
				} else {
					$retour['result'] = false;
					$retour['message'] = '<div class="alert alert-danger">Le thème demandé n\'existe pas !</div>';
				}
			} else {
				$retour['result'] = false;
				$retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
			}
			echo json_encode($retour);      
		}

		// Fonction qui effectue le changement de thème dans la BDD
		public static function changeTheme() {
			self::isAdmin();
			if(isset($_POST['nameTheme'], $_POST['confirm'])) {
				$nameTheme = htmlspecialchars($_POST['nameTheme']);
				$confirm = htmlspecialchars($_POST['confirm']);
				$filePath = File::build_path(array('view', 'themes', $nameTheme, 'template.json'));
				if(file_exists($filePath)) {
					if($confirm == true) {
						$data = array(
							'nameOption' => 'theme_site',
							'valueOption' => $nameTheme
						);
						$checkUpdateOption = ModelOption::update_gen($data, 'nameOption');
						if($checkUpdateOption) {
							$message = '<div class="alert alert-success">Le thème a bien été changé !</div>';
						} else {
							$message = '<div class="alert alert-danger">Impossible d\'enregistrer le changement de thème !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez confirmer le changement de thème !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Ce thème n\'existe pas !</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de changement de thème !</div>';
			}
			self::themes($message);
		}
	}
?>