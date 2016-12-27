<?php 
	class ControllerAdminChambres extends ControllerAdmin {

		public static function chambres($message = null) {
			$powerNeeded = self::isAdmin();
			$view = 'listChambres';
			$pagetitle = 'Administration - Liste des chambres';
			$template = 'admin';
			$tab_chambres = ModelChambre::selectAll();
			require_once File::build_path(array("view","main_view.php"));
		}

		public static function addChambre(){
			$powerNeeded = self::isAdmin();
			$view = 'addChambre';
			$pagetitle = 'Administration - Ajouter une chambre';
			$template = 'admin';

			require_once File::build_path(array("view","main_view.php"));
		}

		public static function addedChambre(){
			$powerNeeded = self::isAdmin();
			if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){

				if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){

					if($_POST['prix']>=0 && $_POST['superficie']>=0){
						// TODO : --------
						$laChambre = array(
							'idChambre' => NULL,
							'nomChambre' => $_POST['nom'],
							'descriptionChambre' => $_POST['description'],
							'prixChambre' => $_POST['prix'],
							'superficieChambre' => $_POST['superficie'],
						);
						$save = ModelChambre::save($laChambre);
						if($save!=false){
							$message = '<div class="alert alert-success">Chambre ajoutée avec succès !</div>';
						}else{
							$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la creation de la chambre !</div>';
						
						}
					}else{
						$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zero !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide avoir un prix ou une seperficie inferieur a zero !</div>';
				}   
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
			}
			self::chambres($message);
		}

		public static function editChambre(){
			$powerNeeded = self::isAdmin();
			$view = 'editChambre';
			$pagetitle = 'Administration - Editeur de chambre';
			$template = 'admin';
			
			if(isset($_GET['idChambre'])){
				$chambre = ModelChambre::select($_GET['idChambre']);

				if($chambre!=false){
					require_once File::build_path(array("view","main_view.php"));
				}else{
					$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
					self::chambres($message);
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas modifier une chambre sans connaitre son ID !</div>';
				self::chambres($message);
			}
		}

		public static function editedChambre(){
			$powerNeeded = self::isAdmin();
			if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){

				if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){

					if($_POST['prix']>=0 && $_POST['superficie']>=0){
						$laChambre = array(
							'idChambre' => $_POST['id'],
							'nomChambre' => $_POST['nom'],
							'descriptionChambre' => $_POST['description'],
							'prixChambre' => $_POST['prix'],
							'superficieChambre' => $_POST['superficie'],
						);
						$update = ModelChambre::update_gen($laChambre, 'idChambre');
						if($update!=false){
							$message = '<div class="alert alert-success">Chambre modifiées avec succès !</div>';
						}else{
							$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la mise a jour de la chambre !</div>';
						}
					}else{
						$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zero !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide avoir un prix ou une seperficie inferieur a zero !</div>';
				}   
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
			}
			self::chambres($message);
		}

		public static function deleteChambre() {
			$powerNeeded = self::isAdmin();
			// Attend un $_GET['idChambre']
			if (isset($_GET['idChambre']) && $_GET['idChambre']!=null) {
				$idChambre = $_GET['idChambre'];
				if(ModelChambre::select($idChambre)!=null){
					if(ModelChambre::delete($idChambre)){
						$message = '<div class="alert alert-success">La suppresion de la chambre a été effectuée avec succes !</div>';
					}else{
						$message = '<div class="alert alert-danger">Un probleme est survenue lors de la suppression de la chambre !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Cette chambre n\'existe deja plus !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas supprimer une chambre sans connaitre son ID !</div>';
			}
			self::chambres($message);
		}
	}
?>