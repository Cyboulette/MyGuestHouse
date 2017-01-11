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

		public static function read(){
			$powerNeeded = self::isAdmin();
			$view = 'readChambre';
			$pagetitle = 'Administration - Liste des chambres';
			$template = 'admin';
			
			if (isset($_GET["idChambre"])) {
	            $idChambre = $_GET["idChambre"];
		        $chambre = ModelChambre::select($idChambre);
	            if ($chambre!=false) {
	                $tab_photo = ModelChambre::selectPhoto($idChambre);
	                $tab_detail = ModelDetail::selectForChambre($idChambre);
	                $tab_prestation = ModelPrestation::selectAllByChambre($idChambre);

	                $compteur = true;
	                foreach ($tab_photo as $key => $value) {
	                  $photo = $tab_photo[$key][0];
	                  if (!file_exists(File::build_path(array($photo)))) {
	                    ModelChambre::delatePhoto($photo);// suppression de la photo de la bdd si elle nexiste pas physiquement
	                    $compteur = false;
	                  }
	                }
	                if (!$compteur) {
	                    $tab_photo = ModelChambre::selectPhoto($idChambre);
	                }
	                
	                require_once File::build_path(array("view","main_view.php"));
	            }else{
	            	$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
	                self::chambres($message);
	            }
	    	}else{
	    		$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer votre requête !</div>';
	    		self::chambres($message);
	    	}
		}

		public static function addChambre(){
			$powerNeeded = self::isAdmin();
			$view = 'addChambre';
			$pagetitle = 'Administration - Ajouter une chambre';
			$template = 'admin';
			if(ModelChambre::count()<5){
				require_once File::build_path(array("view","main_view.php"));
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir plus de 5 chambre (selon la législation mise en place en France) !</div>';
				self::chambres($message);
			}
			
		}

		public static function addedChambre(){
			$powerNeeded = self::isAdmin();
			if(ModelChambre::count()<5){
				if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){

					if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){
						if(is_numeric($_POST['prix']) && is_numeric($_POST['superficie'])) {
							if($_POST['prix']>=0 && $_POST['superficie']>=0){
								$laChambre = array(
									'idChambre' => NULL,
									'nomChambre' => htmlspecialchars($_POST['nom']),
									'descriptionChambre' => htmlspecialchars($_POST['description']),
									'prixChambre' => htmlspecialchars($_POST['prix']),
									'superficieChambre' => htmlspecialchars($_POST['superficie'])
								);
								$save = ModelChambre::save($laChambre);
								if($save!=false){
									$message = '<div class="alert alert-success">Chambre ajoutée avec succès !</div>';
								}else{
									$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la création de la chambre !</div>';
								
								}
							}else{
								$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zero !</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Vous devez saisir un prix et une superficie en valeur numérique !</div>';
						}
					}else{
						$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide ou avoir un prix ou une seperficie inferieur a zero !</div>';
					}   
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir plus de 5 chambre (selon la législation mise en place en France) !</div>';
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
				// GROS SOUCIS ICI !! Il faut vérifier que la chambre passée en paramètre via son ID existe bel et bien, comme pour les prestations et détails :)
				// Je te laisses le faire.
				if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){
					if(is_numeric($_POST['prix']) && is_numeric($_POST['superficie'])) {
						if($_POST['prix']>=0 && $_POST['superficie']>=0){
							$laChambre = array(
								'idChambre' => $_POST['id'],
								'nomChambre' => htmlspecialchars($_POST['nom']),
								'descriptionChambre' => htmlspecialchars($_POST['description']),
								'prixChambre' => htmlspecialchars($_POST['prix']),
								'superficieChambre' => htmlspecialchars($_POST['superficie'])
							);
							$update = ModelChambre::update_gen($laChambre, 'idChambre');
							if($update!=false){
								$message = '<div class="alert alert-success">Chambre modifiée avec succès !</div>';
							}else{
								$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la mise a jour de la chambre !</div>';
							}
						}else{
							$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zéro !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez saisir un prix et une superficie en valeur numérique !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide avoir un prix ou une seperficie inferieur a zero !</div>';
				}   
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
			}
			self::chambres($message);
		}

		public static function preDeleteItem() {
			self::deleteItemForm("adminChambres", "ModelChambre", "de la chambre", "nomChambre", 'idChambre');
		}

		public static function deleteItem() {
			self::isAdmin();
			if(isset($_POST['idItem'], $_POST['confirm'])) {
				$idItem = htmlspecialchars($_POST['idItem']);
				$confirm = htmlspecialchars($_POST['confirm']);
				$item = ModelChambre::select($idItem);
				if($item != false) {
					if($confirm == true) {
						$checkDeleteItem = ModelChambre::delete($item->get('idChambre'));
						if($checkDeleteItem) {
							$message = '<div class="alert alert-success">La chambre a bien été supprimée !</div>';
						} else {
							$message = '<div class="alert alert-danger">Impossible de supprimer cette chambre !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Cette chambre n\'existe pas</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
			}
			self::chambres($message);
		}
	}
?>