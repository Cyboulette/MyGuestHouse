<?php 
	class ControllerAdminAvis extends ControllerAdmin {

		// public static function chambres($message = null) {
		// 	$powerNeeded = self::isAdmin();
		// 	$view = 'listChambres';
		// 	$pagetitle = 'Administration - Liste des chambres';
		// 	$template = 'admin';
		// 	$tab_chambres = ModelChambre::selectAll();
		// 	require_once File::build_path(array("view","main_view.php"));
		// }

		// public static function read(){
		// 	$powerNeeded = self::isAdmin();
		// 	$view = 'readChambre';
		// 	$pagetitle = 'Administration - Liste des chambres';
		// 	$template = 'admin';
			
		// 	if (isset($_GET["idChambre"])) {
	 	//         $idChambre = $_GET["idChambre"];
		//         $chambre = ModelChambre::select($idChambre);
	 //            if ($chambre!=false) {
	 //                $tab_photo = ModelChambre::selectPhoto($idChambre);
	 //                $tab_detail = ModelDetail::selectForChambre($idChambre);
	 //                $tab_prestation = ModelPrestation::selectAllByChambre($idChambre);

	 //                $compteur = true;
	 //                foreach ($tab_photo as $key => $value) {
	 //                  $photo = $tab_photo[$key][0];
	 //                  if (!file_exists(File::build_path(array($photo)))) {
	 //                    ModelChambre::delatePhoto($photo);// suppression de la photo de la bdd si elle nexiste pas physiquement
	 //                    $compteur = false;
	 //                  }
	 //                }
	 //                if (!$compteur) {
	 //                    $tab_photo = ModelChambre::selectPhoto($idChambre);
	 //                }
	                
	 //                require_once File::build_path(array("view","main_view.php"));
	 //            }else{
	 //            	$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
	 //                self::chambres($message);
	 //            }
	 //    	}else{
	 //    		$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer votre requête !</div>';
	 //    		self::chambres($message);
	 //    	}
		// }

		// public static function addChambre(){
		// 	$powerNeeded = self::isAdmin();
		// 	$view = 'addChambre';
		// 	$pagetitle = 'Administration - Ajouter une chambre';
		// 	$template = 'admin';
		// 	if(ModelChambre::count()<5){
		// 		require_once File::build_path(array("view","main_view.php"));
		// 	}else{
		// 		$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir plus de 5 chambre (selon la législation mise en place en France) !</div>';
		// 		self::chambres($message);
		// 	}
			
		// }

		// public static function addedChambre(){
		// 	$powerNeeded = self::isAdmin();
		// 	if(ModelChambre::count()<5){
		// 		if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){

		// 			if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){
		// 				if(is_numeric($_POST['prix']) && is_numeric($_POST['superficie'])) {
		// 					if($_POST['prix']>=0 && $_POST['superficie']>=0){
		// 						$laChambre = array(
		// 							'idChambre' => NULL,
		// 							'nomChambre' => htmlspecialchars($_POST['nom']),
		// 							'descriptionChambre' => htmlspecialchars($_POST['description']),
		// 							'prixChambre' => htmlspecialchars($_POST['prix']),
		// 							'superficieChambre' => htmlspecialchars($_POST['superficie'])
		// 						);
		// 						$save = ModelChambre::save($laChambre);
		// 						if($save!=false){
		// 							$message = '<div class="alert alert-success">Chambre ajoutée avec succès !</div>';
		// 						}else{
		// 							$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la création de la chambre !</div>';
								
		// 						}
		// 					}else{
		// 						$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zero !</div>';
		// 					}
		// 				} else {
		// 					$message = '<div class="alert alert-danger">Vous devez saisir un prix et une superficie en valeur numérique !</div>';
		// 				}
		// 			}else{
		// 				$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide ou avoir un prix ou une seperficie inferieur a zero !</div>';
		// 			}   
		// 		}else{
		// 			$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
		// 		}
		// 	}else{
		// 		$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir plus de 5 chambre (selon la législation mise en place en France) !</div>';
		// 	}
		// 	self::chambres($message);
		// }

		// public static function editChambre(){
		// 	$powerNeeded = self::isAdmin();
		// 	$view = 'editChambre';
		// 	$pagetitle = 'Administration - Editeur de chambre';
		// 	$template = 'admin';
			
		// 	if(isset($_GET['idChambre'])){
		// 		$chambre = ModelChambre::select($_GET['idChambre']);

		// 		if($chambre!=false){
		// 			require_once File::build_path(array("view","main_view.php"));
		// 		}else{
		// 			$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
		// 			self::chambres($message);
		// 		}
		// 	}else{
		// 		$message = '<div class="alert alert-danger">Vous ne pouvez pas modifier une chambre sans connaitre son ID !</div>';
		// 		self::chambres($message);
		// 	}
		// }

		// public static function editedChambre(){
		// 	$powerNeeded = self::isAdmin();
		// 	if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){
		// 		// GROS SOUCIS ICI !! Il faut vérifier que la chambre passée en paramètre via son ID existe bel et bien, comme pour les prestations et détails :)
		// 		// Je te laisses le faire.
		// 		if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){
		// 			if(is_numeric($_POST['prix']) && is_numeric($_POST['superficie'])) {
		// 				if($_POST['prix']>=0 && $_POST['superficie']>=0){
		// 					$laChambre = array(
		// 						'idChambre' => $_POST['id'],
		// 						'nomChambre' => htmlspecialchars($_POST['nom']),
		// 						'descriptionChambre' => htmlspecialchars($_POST['description']),
		// 						'prixChambre' => htmlspecialchars($_POST['prix']),
		// 						'superficieChambre' => htmlspecialchars($_POST['superficie'])
		// 					);
		// 					$update = ModelChambre::update_gen($laChambre, 'idChambre');
		// 					if($update!=false){
		// 						$message = '<div class="alert alert-success">Chambre modifiée avec succès !</div>';
		// 					}else{
		// 						$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la mise a jour de la chambre !</div>';
		// 					}
		// 				}else{
		// 					$message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zéro !</div>';
		// 				}
		// 			} else {
		// 				$message = '<div class="alert alert-danger">Vous devez saisir un prix et une superficie en valeur numérique !</div>';
		// 			}
		// 		}else{
		// 			$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide avoir un prix ou une seperficie inferieur a zero !</div>';
		// 		}   
		// 	}else{
		// 		$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
		// 	}
		// 	self::chambres($message);
		// }

		// public static function deleteChambre() {
		// 	$powerNeeded = self::isAdmin();
		// 	// Attend un $_GET['idChambre']
		// 	if (isset($_GET['idChambre']) && $_GET['idChambre']!=null) {
		// 		$idChambre = $_GET['idChambre'];
		// 		if(ModelChambre::select($idChambre)!=null){ // c'est plutôt != false
		// 			if(ModelChambre::delete($idChambre)){
		// 				$message = '<div class="alert alert-success">La suppresion de la chambre a été effectuée avec succes !</div>';
		// 			}else{
		// 				$message = '<div class="alert alert-danger">Un probleme est survenue lors de la suppression de la chambre !</div>';
		// 			}
		// 		}else{
		// 			$message = '<div class="alert alert-danger">Cette chambre n\'existe deja plus !</div>';
		// 		}
		// 	}else{
		// 		$message = '<div class="alert alert-danger">Vous ne pouvez pas supprimer une chambre sans connaitre son ID !</div>';
		// 	}
		// 	self::chambres($message);
		// }




		//--------------------------------------------------



	   // 	public static function edit(){
	   //    	if(ControllerUtilisateur::isConnected()){
	   //       	if(isset($_GET['idUtilisateur'], $_GET['idChambre']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null ){
	   //       		$idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
	   //          	if($idUtilisateur=$_SESSION['idUser']){
	   //          		$idChambre = htmlspecialchars($_GET['idChambre']);
	   //          		$avis = ModelAvis::select($idUtilisateur, $idChambre);
	   //             		if($avis!=null){
	   //                		$view = 'editAvis';
	   //                		$pagetitle = 'Modifiez votre avis';
	   //                		$powerNeeded = true;

	   //              		require File::build_path(array('view', 'main_view.php'));
	   //             		}else{
	   //                		$message = '<div class="alert alert-danger">Cette avis n\'exists plus !</div>';
	   //                		ControllerUtilisateur::profil($message);
	   //             		}
	   //          	}else{
	   //             		$message = '<div class="alert alert-danger">Vous ne pouvez pas modifier un avis que vous n\'avez pas emis !</div>';
	   //             		ControllerUtilisateur::profil($message);
	   //          	}
	   //       	}else{
	   //       		$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la modification de l\'avis !</div>';
	   //          	ControllerUtilisateur::profil($message);
	   //       	}
	   //    	}else{
	   //       	ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
	   //    	}
	   // 	}

	   // public static function edited(){
	   //    if(ControllerUtilisateur::isConnected()){
	   //       if(isset($_POST['idUtilisateur'], $_POST['avis'], $_POST['note'], $_POST['idChambre'])){
	   //          if($_POST['idUtilisateur']!=null && $_POST['avis']!=null && $_POST['idChambre']!=null){
	   //             $utilisateur = ModelUtilisateur::select($_POST['idUtilisateur']);
	   //             $chambre = ModelChambre::select($_POST['idChambre']);
	   //             if($utilisateur!=false){
	   //                if($_POST['idUtilisateur']==$_SESSION['idUser']){
	   //                   if($chambre!=false){
	   //                      if(is_numeric($_POST['note']) && $_POST['note']>=0 && $_POST['note']<=5){
	   //                         $utilisateur = ModelUtilisateur::select($_POST['idUtilisateur']);
	   //                         $chambre = ModelChambre::select($_POST['idChambre']);

	   //                         $avis = htmlspecialchars($_POST['avis']);
	   //                         $idUtilisateur = $utilisateur->get('idUtilisateur');
	   //                         $idChambre = $chambre->get('idChambre');
	   //                         $note = htmlspecialchars($_POST['note']);

	   //                         $lavis = array(
	   //                            'idChambre' => $idChambre,
	   //                            'idUtilisateur' => $idUtilisateur,
	   //                            'note' => $note,
	   //                            'commentaire' => $avis
	   //                         );

	   //                         $update = ModelAvis::update($lavis);

	   //                         if($update){
	   //                            $message = '<div class="alert alert-success">Votre avis a été modifié avec succés !</div>';
	   //                         }else{
	   //                            $message = '<div class="alert alert-danger">Nous n\'avons pas pu proceder a la modification de l\'avis !</div>';
	   //                         }     
	   //                      }else{   
	   //                         $message = '<div class="alert alert-danger">Vous devez donner une note entre 0 et 5 (en valeur numerique) !</div>';
	   //                      }
	   //                   }else{
	   //                      $message = '<div class="alert alert-danger">La chambre sur laquelle vous voulez modifier l\'avis n\'existe plus !</div>';
	   //                   }
	   //                }else{
	   //                   $message = '<div class="alert alert-danger">Vous ne pouvez pas modifier un avis que vous n\'avez pas emis !</div>';
	   //                }
	   //             }else{
	   //                ControllerDefault::error('Vous n\'avez pas de compte chez nous pour l\'instant !');
	   //             }
	   //          }else{
	   //             $message = '<div class="alert alert-danger">Vous devez renseigner touts les champs afin de modifier votre avis !</div>';
	   //          }
	   //       }else{
	   //          $message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer vos infomations sur l\'avis !</div>';
	   //       }
	   //       ControllerUtilisateur::profil($message);
	   //    }else{
	   //       ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
	   //    }
	   // }

	   	public static function delete(){
	   		$powerNeeded = self::isAdmin();

	   		if(isset($_GET['idUtilisateur'], $_GET['idChambre']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null ){
	   			$idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
				$idChambre = htmlspecialchars($_GET['idChambre']);

        		$utilisateur = ModelUtilisateur::select($idUtilisateur);
		        if($utilisateur!=null){
					// if( $idUtilisateur == $_SESSION['idUser'] ){
					// 	$oneself = true;
					// }else{
					// 	$oneself = false;
					// }

					// $nom = htmlspecialchars($utilisateur->get('nomUtilisateur'));
					// $prenom = htmlspecialchars($utilisateur->get('prenomUtilisateur'));

		        	$chambre = ModelChambre::select($idChambre);
		        	if($chambre!=null){
		        		$avis = ModelAvis::select($idUtilisateur, $idChambre);
				        if($avis!=null){
				            $delete = ModelAvis::delete($idUtilisateur, $idChambre);
				            if($delete){
				                $message = '<div class="alert alert-success">la suppression de l\'avis est un succes !</div>';
				            }else{
				                $message = '<div class="alert alert-danger">Nous n\'avons pas pu supprimer l\'avis, merci de réessayer plus tard !</div>';
				            }
				        }else{
				            $message = '<div class="alert alert-danger">Cette avis n\'exists déja plus !</div>';
				        }
		        	}else{
			        	$message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
			    	}  	
			    }else{
			        $message = '<div class="alert alert-danger">Cet utilisateur n\'existe plus !</div>';
			    }  
	   		}else{
	   			$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer le informations necessaires a la suppression de l\'avis !</div>';
	   		}
			ControllerAdminUtilisateurs::read($idUtilisateur, $message);
		    // if(ControllerUtilisateur::isConnected()){
		    //     if(isset($_GET['idUtilisateur'], $_GET['idChambre']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null ){
		    //         $idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
		    //         if($idUtilisateur=$_SESSION['idUser']){
		    //            	$idChambre = htmlspecialchars($_GET['idChambre']);
		    //            	$avis = ModelAvis::select($idUtilisateur, $idChambre);
		    //            	if($avis!=null){
		    //               	$delete = ModelAvis::delete($idUtilisateur, $idChambre);
		    //               	if($delete){
		    //                  	$message = '<div class="alert alert-success">la suppression de l\'avis est un succes !</div>';
		    //               	}else{
		    //                  	$message = '<div class="alert alert-danger">Nous n\'avons pas pu supprimer l\'avis, merci de réessayer plus tard !</div>';
		    //               	}
		    //            	}else{
		    //               	$message = '<div class="alert alert-danger">Cette avis n\'exists déja plus !</div>';
		    //            	}
		    //         }else{
		    //            	$message = '<div class="alert alert-danger">Vous ne pouvez pas supprimmer un avis que vous n\'avez pas emis !</div>';
		    //         }
		    //     }else{
		    //         $message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la suppression de l\'avis !</div>';
		    //     }
		    //     ControllerUtilisateur::profil($message);
		    // }else{
		    //     ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
		    // }
	   	}


	}
?>