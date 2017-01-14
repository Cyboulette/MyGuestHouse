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

		public static function addImage() {
			self::isAdmin();
			if(isset($_POST['idChambre'])) {
				$chambre = ModelChambre::select($_POST['idChambre']);
				if($chambre != false) {
					$image = $_FILES['image'];
					if(!empty($image['name'])) {
						$extensionsOK = array('jpg', 'jpeg', 'gif', 'png');
						$extensionUpload = strtolower(substr(strrchr($image['name'], '.'), 1));
						if (in_array($extensionUpload, $extensionsOK)) { //Si c'est la bonne extension de fichier !
							$dir = "assets/images/chambre/image_upload_" . time() . ".png";
							$resultat = move_uploaded_file($image['tmp_name'], $dir);
							if($resultat) {
								$checkAddImage = $chambre->addPhoto($dir);
								if($checkAddImage) {
									$message = '<div class="alert alert-success">Image ajoutée avec succès !</div>';
								} else {
									$testFile = $dir;
									if(file_exists($testFile)) {
										unlink($testFile);
									}
									$message = '<div class="alert alert-danger">Erreur inconnue lors de le l\'enregistrement, veuillez nous contacter !</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">Impossible d\'enregistrer l\'image</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Merci d\'envoyer une image au format png/jpg/jpeg/gif !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">La chambre pour laquelle vous essayez d\'ajouter une image n\'existe pas</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire !</div>';
			}
			self::chambres($message);
		}

		public static function deleteImage() {
			self::isAdmin();
			if(isset($_POST['idVisuel'],$_POST['idChambre'],$_POST['confirm'])) {
				$idVisuel = htmlspecialchars($_POST['idVisuel']);
				$idChambre = htmlspecialchars($_POST['idChambre']);
				$visuel = ModelChambre::getImage($idChambre, $idVisuel);

				if($visuel != false) {
					$confirm = htmlspecialchars($_POST['confirm']);
					if($confirm == true) {
						$urlVisuel = $visuel['urlVisuel'];
						$checkDeleteImage = ModelChambre::deleteImage($idVisuel);
						if($checkDeleteImage) {
							if(file_exists($urlVisuel)) {
								unlink($urlVisuel);
							}
							$notif = '<div class="alert alert-success">L\'image a bien été supprimée !</div>';
						} else {
							$notif = '<div class="alert alert-danger">Impossible de supprimer cette image, veuillez nous contacter !</div>';
						}
					} else {
						$notif = '<div class="alert alert-danger">Vous devez confirmer la suppression si vous cliquez sur le bouton "Confirmer" !</div>';
					}
				} else {
					$notif = '<div class="alert alert-danger">L\'image demandée n\'existe pas !</div>';
				}
			} else {
				$notif = '<div class="alert alert-danger">Merci de remplir correctement le formulaire !</div>';
			}
			self::chambres($notif);
		}

		public static function imagesForm() {
			$retour = array();
			self::isAdmin();
			if(isset($_POST['idChambre'])) {
				$idChambre = htmlspecialchars($_POST['idChambre']);
				$chambre = ModelChambre::select($idChambre);
				if($chambre != false) {
					$images = $chambre->selectPhoto();
					$formAdd = '<form enctype="multipart/form-data" method="POST" role="form" action="index.php?controller=adminChambres&action=addImage">
							<div class="form-group">
								<label for="image">Image à ajouter</label>
								<input id="image" required class="form-control" type="file" name="image" placeholder="Sélectionnez une image" />
							</div>
							<div class="form-group">
								<input type="hidden" required name="idChambre" value="'.$idChambre.'">
								<button type="submit" class="btn btn-success">Ajouter</button>
							</div>
						</form>';

					if($images != false) {
						$formTable = '<div class="table-responsive">
							<table class="table table-hover listProduitsTable">
								<thead>
									<tr>
										<th>ID Visuel</th>
										<th>URL</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>';

						foreach ($images as $image) {
							$idVisuel = $image['idVisuel'];
							$urlImage = $image['urlVisuel'];
							$formTable .= '<tr data-chambre="'.$idChambre.'" data-visuel="'.$idVisuel.'">
								<td>'.$idVisuel.'</td>
								<td><a target="_blank" href="'.$urlImage.'">'.$urlImage.'</a></td>
								<td>
									<button class="btn btn-xs btn-danger btnImages" data-action="deleteImageForm"><i class="fa fa-trash" aria-hidden="true"></i> Supprimer</button>
								</td>
							</tr>';
						}

						$formTable .= '</tbody>
							</table>
						</div>
						<script>imagesBtn();</script>';

						$retour['result'] = true;
						$retour['message'] = $formAdd."<hr/>".$formTable;
					} else {
						$retour['result'] = true;
						$retour['message'] = $formAdd.'<div class="alert alert-warning text-center">Cette chambre ne possède aucune image pour le moment</div>';
					}
				} else {
					$retour['result'] = false;
					$retour['message'] = '<div class="alert alert-danger">La chambre demandée n\'existe pas</div>';
				}
			}
			echo json_encode($retour);
		}

	public static function deleteImageForm() {
		$retour = array(); //Tableau de retour
		self::isAdmin();
		if(isset($_POST['idChambre'], $_POST['idVisuel'])) {
			$idChambre = htmlspecialchars($_POST['idChambre']);
			$idVisuel = htmlspecialchars($_POST['idVisuel']);
			$chambre = ModelChambre::select($idChambre);

			if($chambre != false) {
				$visuel = ModelChambre::getImage($idChambre, $idVisuel);
				if($visuel != false) {
					$urlVisuel = $visuel['urlVisuel'];
					$form = '<form method="POST" role="form" action="index.php?controller=adminChambres&action=deleteImage">
						<div class="alert alert-info text-center">
							Confirmez vous la suppression du visuel <b><a target="_blank" href="assets/images/chambre/'.$urlVisuel.'">'.$urlVisuel.'</a></b> ?
						</div>

						<input type="hidden" required name="idChambre" value="'.$idChambre.'">
						<input type="hidden" required name="idVisuel" value="'.$idVisuel.'">
						<input type="hidden" required name="confirm" value="true">

						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmer</button>
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>
						</div>
					</form>';
					$retour['result'] = true;
					$retour['message'] = $form;
				} else {
					$retour['result'] = false;
					$retour['message'] = '<div class="alert alert-danger">Cette image n\'existe pas, ou n\'est plus associée à cette chambre</div>';
				}
				} else {
				$retour['result'] = false;
				$retour['message'] = '<div class="alert alert-danger">La chambre associée à cette n\'existe pas !</div>';
			}
		} else {
			$retour['result'] = false;
			$retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
		}
		echo json_encode($retour);
	}
	}
?>