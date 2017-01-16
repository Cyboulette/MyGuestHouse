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

		//--------------------------------------------------


	   	public static function edit(){
	      	$powerNeeded = self::isAdmin();
	        if(isset($_GET['idUtilisateur'], $_GET['idChambre'], $_GET['from']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null && $_GET['from']!=null){
	         	$from = htmlspecialchars($_GET['from']);
	         	$idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
	            $idChambre = htmlspecialchars($_GET['idChambre']);
	            if($from == 'chambre' || $from == 'utilisateur'){
		            $utilisateur = ModelUtilisateur::select($idUtilisateur);
		            if($utilisateur!=false){
		            	$chambre = ModelChambre::select($idChambre);
		            	if($chambre!=false){
		            		$avis = ModelAvis::select($idUtilisateur, $idChambre);
				            if($avis!=null){
				                $view = 'editAvis';
				                $pagetitle = 'Modifiez votre avis';
				                $template = 'admin';

				                $idUtilisateur = $avis->get('idUtilisateur');
							    $idChambre = $avis->get('idChambre');
							    $note = $avis->get('note');
							    $commentaire = $avis->get('commentaire');
							    $nomChambre = $chambre->get('nomChambre');
							    $prenomUtilisateur = $utilisateur->get('prenomUtilisateur');
							    $nomUtilisateur = $utilisateur->get('nomUtilisateur');

				                require File::build_path(array('view', 'main_view.php'));
				            }else{
				                $message = '<div class="alert alert-danger">Cette avis n\'existe plus !</div>';
				                if($from == 'chambre'){
				                	ControllerAdminChambres::read($idChambre, $message);
				                }else if($from == 'utilisateur'){
				                	ControllerAdminUtilisateurs::read($idUtilisateur, $message);
				                }
				            }
				        }else{
				            $message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
				            if($from == 'chambre'){
				                ControllerAdminChambres::read($idChambre, $message);
				            }else if($from == 'utilisateur'){
				                ControllerAdminUtilisateurs::read($idUtilisateur, $message);
				            }
				        } 
			        }else{
			            $message = '<div class="alert alert-danger">Cet utilisateur n\'existe plus !</div>';
			            if($from == 'utilisateur'){
			                ControllerAdminUtilisateurs::utilisateurs($message);
			            }else if($from == 'chambre'){
			            	ControllerAdminChambres::read($idChambre, $message);
			            }
			        } 
			    }else{
			    	ControllerAdmin::index();
			    }  
	        }else{
	         	$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la modification de l\'avis !</div>';
	            ControllerAdmin::index();
	        }
	   	}


	   	public static function edited(){
	      	$powerNeeded = self::isAdmin();
	        if(isset($_POST['idUtilisateur'], $_POST['idChambre'], $_POST['from'] ) && $_POST['idUtilisateur']!=null && $_POST['idChambre']!=null && $_POST['from']!=null){
	         	$from = htmlspecialchars($_POST['from']);
	         	$idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
	            $idChambre = htmlspecialchars($_POST['idChambre']);

	            if($from == 'chambre' || $from == 'utilisateur'){
	            	if(isset($_POST['note'], $_POST['avis'])){
	            		$note = htmlspecialchars($_POST['note']);
	            		$avis = htmlspecialchars($_POST['avis']);
				        $utilisateur = ModelUtilisateur::select($idUtilisateur);
				        if($utilisateur!=false){
				           	$chambre = ModelChambre::select($idChambre);
				           	if($chambre!=false){
					            $checkAvis = ModelAvis::select($idUtilisateur, $idChambre);
							    if($checkAvis!=null){
							        if($note!=null && $avis!=null){
							        	if(is_numeric($note) && $note>=0 && $note<=5){
							        		$lavis = array(
				                              'idChambre' => $idChambre,
				                              'idUtilisateur' => $idUtilisateur,
				                              'note' => $note,
				                              'commentaire' => $avis
				                           );

				                           $update = ModelAvis::update($lavis);

				                           if($update){
				                              $message = '<div class="alert alert-success">L\'avis a été modifié avec succés !</div>';
				                           }else{
				                              $message = '<div class="alert alert-danger">Nous n\'avons pas pu proceder a la modification de l\'avis !</div>';
				                           }

				                           if($from == 'chambre'){
										        ControllerAdminChambres::read($idChambre, $message);
										    }else if($from == 'utilisateur'){
										        ControllerAdminUtilisateurs::read($idUtilisateur, $message);
										    }
							        	}else{
										    $message = '<div class="alert alert-danger">Vous devez donner une note entre 0 et 5 (en valeur numerique) !</div>';
										    if($from == 'chambre'){
										        ControllerAdminChambres::read($idChambre, $message);
										    }else if($from == 'utilisateur'){
										        ControllerAdminUtilisateurs::read($idUtilisateur, $message);
										    }
										}
							        }else{
									    $message = '<div class="alert alert-danger">Vous devez remplir tous les champs pour procéder à la modification de l\'avis !</div>';
									    if($from == 'chambre'){
									        ControllerAdminChambres::read($idChambre, $message);
									    }else if($from == 'utilisateur'){
									        ControllerAdminUtilisateurs::read($idUtilisateur, $message);
									    }
									}       
							    }else{
							        $message = '<div class="alert alert-danger">Cette avis n\'existe plus !</div>';
							        if($from == 'chambre'){
							            ControllerAdminChambres::read($idChambre, $message);
							        }else if($from == 'utilisateur'){
							            ControllerAdminUtilisateurs::read($idUtilisateur, $message);
							        }
							    }
						    }else{
						        $message = '<div class="alert alert-danger">Cette chambre n\'existse plus !</div>';
						        if($from == 'chambre'){
						            ControllerAdminChambres::read($idChambre, $message);
						        }else if($from == 'utilisateur'){
						            ControllerAdminUtilisateurs::read($idUtilisateur, $message);
						        }
						    } 
					    }else{
					        $message = '<div class="alert alert-danger">Cet utilisateur n\'existe plus !</div>';
					        if($from == 'utilisateur'){
					            ControllerAdminUtilisateurs::utilisateurs($message);
					        }else if($from == 'chambre'){
					        	ControllerAdminChambres::read($idChambre, $message);
					        }
					    }
				    }else{
				    	$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la modification de l\'avis !</div>';
				    	if($from == 'utilisateur'){
				            ControllerAdminUtilisateurs::read($idUtilisateur, $message);
				        }else if($from == 'chambre'){
				        	ControllerAdminChambres::read($idChambre, $message);
				        }
				    }
			    }else{
			    	ControllerAdmin::index();
			    }  
	        }else{
	            ControllerAdmin::index();
	        }
	   	}

	   	public static function delete(){
	      	$powerNeeded = self::isAdmin();
	        if(isset($_GET['idUtilisateur'], $_GET['idChambre'], $_GET['from']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null && $_GET['from']!=null){
	         	$from = htmlspecialchars($_GET['from']);
	         	$idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
	            $idChambre = htmlspecialchars($_GET['idChambre']);
	            if($from == 'chambre' || $from == 'utilisateur'){
		            $utilisateur = ModelUtilisateur::select($idUtilisateur);
		            if($utilisateur!=false){
		            	$chambre = ModelChambre::select($idChambre);
		            	if($chambre!=false){
		            		$avis = ModelAvis::select($idUtilisateur, $idChambre);
				            if($avis!=null){
				            	$delete = ModelAvis::delete($idUtilisateur, $idChambre);
			                  	if($delete){
			                     	$message = '<div class="alert alert-success">La suppression de l\'avis est un succès !</div>';
			                  	}else{
			                     	$message = '<div class="alert alert-danger">Nous n\'avons pas pu supprimer l\'avis, merci de réessayer plus tard !</div>';
			                  	}

			                  	if($from == 'chambre'){
				                	ControllerAdminChambres::read($idChambre, $message);
				                }else if($from == 'utilisateur'){
				                	ControllerAdminUtilisateurs::read($idUtilisateur, $message);
				                }
				            }else{
				                $message = '<div class="alert alert-danger">Cette avis n\'existe déja plus !</div>';
				                if($from == 'chambre'){
				                	ControllerAdminChambres::read($idChambre, $message);
				                }else if($from == 'utilisateur'){
				                	ControllerAdminUtilisateurs::read($idUtilisateur, $message);
				                }
				            }
				        }else{
				            $message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
				            if($from == 'chambre'){
				                ControllerAdminChambres::read($idChambre, $message);
				            }else if($from == 'utilisateur'){
				                ControllerAdminUtilisateurs::read($idUtilisateur, $message);
				            }
				        } 
			        }else{
			            $message = '<div class="alert alert-danger">Cet utilisateur n\'existe plus !</div>';
			            if($from == 'utilisateur'){
			                ControllerAdminUtilisateurs::utilisateurs($message);
			            }else if($from == 'chambre'){
			            	ControllerAdminChambres::read($idChambre, $message);
			            }
			        } 
			    }else{
			    	ControllerAdmin::index();
			    }  
	        }else{
	         	$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la suppression de l\'avis !</div>';
	            ControllerAdmin::index();
	        }
	   	}


	}
?>