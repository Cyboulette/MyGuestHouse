<?php 
	class ControllerAdminDetails extends ControllerAdmin {
		public static function details($message = null){
			$powerNeeded = self::isAdmin();
			$view = 'listDetails';
			$pagetitle = 'Administration - Options du site';
			$template = 'admin';
			$tab_allDetails = ModelDetail::selectAll();
			require_once File::build_path(array("view","main_view.php"));
		}

		public static function addDetail(){
			$powerNeeded = self::isAdmin();
			$view = 'addDetail';
			$pagetitle = 'Administration - Ajout de détail';
			$template = 'admin';
			require_once File::build_path(array("view","main_view.php"));
		}

		public static function addedDetail(){
			$powerNeeded = self::isAdmin();
			if(isset($_POST['nomDetail'])){
				if($_POST['nomDetail']!=null){
					$leDetail = array(
						'idDetail' => null,
						'nomDetail' => htmlspecialchars($_POST['nomDetail'])
					);
					$save = ModelDetail::save($leDetail);
					if($save != false) {
						$message = '<div class="alert alert-success">Détail ajoutée avec succès !</div>';
					}else{
						$message = '<div class="alert alert-danger">Echec de l\'ajout du détail !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">vous ne pouvez pas laisser un champ vide !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
			}
			self::details($message);
		}

		public static function editDetail(){
			$powerNeeded = self::isAdmin();
			if(isset($_GET['idDetail']) && $_GET['idDetail']!=null){
				$detail = ModelDetail::select($_GET['idDetail']);
				if($detail!=false){
					$view = 'editDetail';
					$pagetitle = 'Administration - modifier un détail';
					$template = 'admin';
					require_once File::build_path(array("view", "main_view.php"));
				}else{
					$message = '<div class="alert alert-danger">Ce détail n\'existe plus !</div>';
					self::details($message);
				}
			}else{
				$message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
				self::details($message);
			}
		}

		public static function editedDetail(){
			$powerNeeded = self::isAdmin();
			if(isset($_POST['idDetail']) && $_POST['idDetail']!=null) {
				$detail = ModelDetail::select($_POST['idDetail']);
				if($detail!=false){
					if(isset($_POST['nomDetail']) && $_POST['nomDetail']!=null){
							$id = htmlspecialchars($detail->get('idDetail'));
							$nom = htmlspecialchars($_POST['nomDetail']);
							$dataDetail = array(
								'nomDetail' => $nom,
								'idDetail' => $id,
							);
							$update = ModelDetail::update_gen($dataDetail, 'idDetail');
							if($update != false) {
								$message = '<div class="alert alert-success">Détail modifiée avec succès !</div>';
							} else {
								$message = '<div class="alert alert-danger">Echec de la modification du détail !</div>';
							}
					}else{
						$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Ce détail n\'existe plus !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
			}
			self::details($message);
		}

		public static function manageDetails() {
			$powerNeeded = self::isAdmin();
			if(isset($_GET['idChambre']) && $_GET['idChambre']!=NULL){
				$chambre = ModelChambre::select($_GET['idChambre']);
				if($chambre!=null){
					$view = 'detailFor';
					$pagetitle = 'Administration - Editeur de chambre';
					$template = 'admin';
					$idChambre = $_GET['idChambre'];
					$tab_detail = ModelDetail::selectAllByChambre($_GET['idChambre']);
					$tab_allDetails = ModelDetail::selectAll();
					require_once File::build_path(array("view", "main_view.php"));
				}else{
					$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
					ControllerAdminChambres::chambres($message);
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez modifier les détails d\'une chambre sans connaître son ID !</div>';
				ControllerAdminChambres::chambres($message);
			}
		}

		public static function managedDetail(){
	        $powerNeeded = self::isAdmin();
	        if(isset($_POST['idChambre']) && $_POST['idChambre']!=null){
	            $idChambre = $_POST['idChambre'];

	            $update = ModelDetail::deleteAllByChambre($idChambre); //TODO vérifier si true
	            if($update){
	                foreach ($_POST as $key => $value){
	                    $idDetail = substr($key, 0, 7);

	                    if($idDetail!="valeur_"){
	                        $todo = false;
	                    }else{
	                        $todo = true;
	                    }

	                    if($todo && $value!=null){
	                        $idDetail = str_replace("valeur_", "", $key);
	                        $update = ModelDetail::saveByChambre($idChambre, $idDetail, $value);
	                    }

	                    if($update == false){
	                        $message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
	                        ControllerAdminChambres::chambres($message);
	                        exit();
	                    }
	                }
	            }
	            if($update != false){
	                $message = '<div class="alert alert-success">Détail modifiée avec succès !</div>';
	            }else{
	                $message = '<div class="alert alert-danger">Echec de la modification de du détail !</div>';
	            }
	        }else{
	            $message = '<div class="alert alert-danger">Vous ne pouvez modifier les détails d\'une chambre sans connaître son ID !</div>';
	        }
	        ControllerAdminChambres::chambres($message);
	    }
	}
?>