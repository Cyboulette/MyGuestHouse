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

		public static function deleteItemForm($controller, $model, $messageSuppr, $itemDisplay, $primaryKey) {
			self::isAdmin();
			$retour = array(); //Tableau de retour
			if(isset($_POST['idToDelete'])) {
				$idToDelete = htmlspecialchars($_POST['idToDelete']);
				$item = $model::select($idToDelete);
				$urlAction = 'index.php?controller='.$controller.'&action=deleteItem';
				if(isset($_GET['mode']) && !empty($_GET['mode'])) {
					$urlAction .= '&mode='.htmlspecialchars($_GET['mode']);
				}

				$valeurDisplayed = htmlspecialchars($item->get($itemDisplay));
				if($itemDisplay == 'urlSlide') {
					$customUrl = '<a target="_blank" href="'.$valeurDisplayed.'">'.$valeurDisplayed.'</a>';
					$valeurDisplayed = $customUrl;
				}

				if($item != false) {
					$form = '<form method="POST" role="form" action="'.$urlAction.'">
						<div class="alert alert-info text-center">
							Confirmez vous la suppression '.$messageSuppr.' <b>'.$valeurDisplayed.'</b> ?
						</div>
						<input type="hidden" name="idItem" value="'.$item->get($primaryKey).'">
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
					$retour['message'] = '<div class="alert alert-danger">Le détail demandé n\'existe pas !</div>';
				}
			} else {
				$retour['result'] = false;
				$retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
			}
			echo json_encode($retour);
		}
	}
?>