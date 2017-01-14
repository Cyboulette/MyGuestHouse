<?php
	class ControllerAdminUtilisateurs extends ControllerAdmin {

		public static function utilisateurs($message = null) {
			$powerNeeded = self::isAdmin();
			$view = 'listUsers';
			$pagetitle = 'Administration - Liste des utilisateurs';
			$template = 'admin';
			if (!isset($_GET['mode'])) {
				$_GET['mode'] = 'all';
			}
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
				$idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
				$utilisateur = ModelUtilisateur::select($idUtilisateur);
				if($utilisateur!=false){
					$view = 'readUser';
					$pagetitle = 'Administration - un utilisateur';
					$template = 'admin';

					$reservationsEnCours = ModelReservation::getReservationsEnCours($idUtilisateur);
					$reservationsEnAttente = ModelReservation::getReservationsEnAttente($idUtilisateur);
					$reservationsFinies = ModelReservation::getReservationsFinis($idUtilisateur);
					$reservationsAnnulees = ModelReservation::getReservationsAnnulee($idUtilisateur);
					$argentDepense = ModelReservation::selectAllPrixByUser($idUtilisateur);
					$tab_reservations = ModelReservation::selectAllByUser($idUtilisateur);

					if ($tab_reservations != null) {
						$dateDebutLastReservation = ControllerDefault::getLastObject(ModelReservation::selectAllByUser($idUtilisateur))->get('dateDebut');
						$dateFinLastReservation = ControllerDefault::getLastObject(ModelReservation::selectAllByUser($idUtilisateur))->get('dateFin');
					}

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

		public static function edit(){
			$powerNeeded = self::isAdmin();
			$view = 'editUser';
			$pagetitle = 'Administration - modification de l\'utilisateur';
			$template = 'admin';

			if(isset($_GET['idUtilisateur'])){
				$utilisateur = ModelUtilisateur::select($_GET['idUtilisateur']);

				if($utilisateur!=false){
					$id = $utilisateur->get('idUtilisateur');
					$nom = $utilisateur->get('nomUtilisateur');
					$prenom = $utilisateur->get('prenomUtilisateur');
					$email = $utilisateur->get('emailUtilisateur');
					$rang = $utilisateur->get('rang') ;
					$statut = $utilisateur->get('nonce');

					if($statut != null){
						$statut = 'Non activé';
					}else{
						$statut = 'Activé';
					}

					if($rang=='1'){
						$rang1="selected='selected'";
						$rang2='';
						$rang3='';
					}else if($rang=='2'){
						$rang1='';
						$rang2="selected='selected'";
						$rang3='';
					}else if($rang=='3'){
						$rang1='';
						$rang2='';
						$rang3="selected='selected'";
					}

					require_once File::build_path(array("view","main_view.php"));
				}else{
					$message = '<div class="alert alert-danger">Cet utilisateur n\'existe plus !</div>';
					self::utilisateurs($message);
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas modifier un utilisateur sans connaitre son ID !</div>';
				self::utilisateurs($message);
			}
		}

		public static function edited(){
			$powerNeeded = self::isAdmin();
			if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['rang'])){

				if($_POST['nom']!=null && $_POST['prenom']!=null && $_POST['email']!=null && $_POST['rang']!=null){
					//if is admin  rang = admin
					$checkUser = ModelUtilisateur::select($_POST['id']);
					if($checkUser){
						$lutilisateur = array(
							'idUtilisateur' => $_POST['id'],
							'emailUtilisateur' => $_POST['email'],
							'nomUtilisateur' => $_POST['nom'],
							'prenomUtilisateur' => $_POST['prenom'],
							'rang' => $_POST['rang']
						);
						$update = ModelUtilisateur::update_gen($lutilisateur, 'idUtilisateur');
						if($update!=false){
							$message = '<div class="alert alert-success">Utilisateur modifié avec succès !</div>';
						}else{
							$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la mise a jour de l\'utilisateur!</div>';
						}
					}else{
						$message = '<div class="alert alert-danger">Cet utilisateur n\'existe pas !</div>';
					}
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par l\'étape de modification !</div>';
			}
			self::utilisateurs($message);
		}

		public static function add(){
			$powerNeeded = self::isAdmin();
			$view = 'addUser';
			$pagetitle = 'Administration - Liste des utilisateurs';
			$template = 'admin';
			require_once File::build_path(array("view", "main_view.php"));
		}

		public static function added(){
			$powerNeeded = self::isAdmin();
			// echo "<pre>";
			// 	print_r($_POST);
			// echo "</pre>";
			if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])
				&& isset($_POST['rang']) && isset($_POST['motDePasse']) && isset($_POST['motDePassebis']) ){

				if($_POST['nom']!=null && $_POST['prenom']!=null && $_POST['email']!=null
					&& $_POST['rang']!=null && $_POST['motDePasse']!=null && $_POST['motDePassebis']!=null
					&& !ctype_space($_POST['nom']) && !ctype_space($_POST['prenom']) && !ctype_space($_POST['email'])){

					$email = strip_tags($_POST['email']);
		            $password = strip_tags($_POST['motDePasse']);
		            $passwordBis = strip_tags($_POST['motDePassebis']);
		            $nom = strip_tags($_POST['nom']);
		            $prenom = strip_tags($_POST['prenom']);
		            $rang = $_POST['rang'];

		            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		               	$checkUser = ModelUtilisateur::selectCustom('emailUtilisateur', $email);
		               	if($checkUser == false) {
		                    if($password == $passwordBis) {
			            		$lutilisateur = array(
									'idUtilisateur' => NULL,
	                                'prenomUtilisateur' => $prenom,
	                                'nomUtilisateur' => $nom,
	                                'emailUtilisateur' => $email,
	                                'password' => password_hash($password, PASSWORD_DEFAULT),
	                                'rang' => $rang,
	                                'nonce' => null
								);
								$save = ModelUtilisateur::save($lutilisateur);
								if($save!=false){
									$message = '<div class="alert alert-success">Utilisateur ajoutée avec succès !</div>';
								}else{
									$message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la création de l\'utilisateur !</div>';
								}
			                }else{
			                    $message='<div class="alert alert-danger">Les mots de passe ne sont pas les même !</div>';
			                }
		               	} else {
		                  	$message='<div class="alert alert-danger">Cette adresse mail est deja utiliser !</div>';
		               	}
		            } else {
		              	$message='<div class="alert alert-danger">L\'adresse e-mail renseignée est invalide !</div>';
		            }
				}else{
					$message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide ou avoir un prix ou une seperficie inferieur a zero !</div>';
				}
			}else{
				$message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
			}
			self::utilisateurs($message);
		}

		public static function preDeleteItem() {
		self::deleteItemForm("adminUtilisateurs", "ModelUtilisateur", "de l'utilisateur", "emailUtilisateur", 'idUtilisateur');
	}

		public static function deleteItem() {
		self::isAdmin();
		if(isset($_POST['idItem'], $_POST['confirm'])) {
			$idItem = htmlspecialchars($_POST['idItem']);
			$confirm = htmlspecialchars($_POST['confirm']);
			$item = ModelUtilisateur::select($idItem);
			if($item != false) {
				if($confirm == true) {
					if($_SESSION['idUser'] != $item->get('idUtilisateur')) {
						$checkDeleteItem = ModelUtilisateur::delete($item->get('idUtilisateur'));
						if($checkDeleteItem) {
							$message = '<div class="alert alert-success">L\'Utilisateur a bien été supprimé !</div>';
						} else {
							$message = '<div class="alert alert-danger">Impossible de supprimer cet utilisateur !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous ne pouvez pas vous auto-supprimer !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Cet utilisateur n\'existe pas</div>';
			}
		} else {
			$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
		}
		self::utilisateurs($message);
	}

		// public static function changePassword(){
	 //    	$powerNeeded = self::isAdmin();
	 //        	$view = 'displayUser';
	 //        	$pagetitle = 'Détail de l\'utilisateur';
	 //        	$powerNeeded = true;

	 //         	$checkUser = ModelUtilisateur::select($_SESSION['idUser']);

		//         if(isset($_POST['ancienMDP']) && isset($_POST['nouveauMDP']) && isset($_POST['nouveauMDPbis'])){
		//             if($_POST['ancienMDP']!=null && $_POST['nouveauMDP']!=null && $_POST['nouveauMDPbis']!=null){
		//                $ancienMDP = strip_tags($_POST['ancienMDP']);
		//                $nouveauMDP = strip_tags($_POST['nouveauMDP']);
		//                $nouveauMDPbis = strip_tags($_POST['nouveauMDPbis']);

		//                	if(password_verify($ancienMDP, $checkUser->get('password'))){
		//                   	if($nouveauMDP == $nouveauMDPbis){
		//                     	$lutilisateur = array(
		//                         	'idUtilisateur' => $_SESSION['idUser'],
		//                         	'password' => password_hash($nouveauMDP, PASSWORD_DEFAULT)
		//                      	);

		// 	                    $update = ModelUtilisateur::update_gen($lutilisateur, 'idUtilisateur');
		// 	                    if($update!=false){
		// 	                    	$message = '<div class="alert alert-success">Votre changement de mot de passe a bien été effectué !</div>';
		// 	                    }else{
		// 	                        $message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la modifictaion de votre mot de passe!</div>';
		// 	                    }
		//                   	}else{
		//                      	$message = '<div class="alert alert-danger">L\'a validation du nouveau mot de passe n\'est pas correct !</div>';
		//                   	}
		//                	}else{
		//                   	$message = '<div class="alert alert-danger">L\'ancien mot de passe est incorrect !</div>';
		//                	}
		//             }else{
		//                $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide !</div>';
		//             }
		//          }else{
		//             $message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par l\'étape de modification !</div>';
		//          }
		//          // pour le vue displayUser ---
		//          $utilisateur= ModelUtilisateur::select($_SESSION['idUser']);
		//          require File::build_path(array('view', 'main_view.php'));
	 //   	}

	}
?>