<?php
	class ControllerAdminNews extends ControllerAdmin {
		// Fonction qui permet de lister les news
		public static function news($message = NULL) {
			$powerNeeded = self::isAdmin();
			$view = 'listNews';
			$pagetitle = 'Administration - Gestion des news';
			$template = 'admin';
			$tab_news = ModelNews::selectAll();
			require_once File::build_path(array("view", "main_view.php"));
		}

		// Fonction qui permet de gérer les news (ajout ou modification)
		public static function manageNews($message = NULL) {
			if(isset($_GET['type'])) {
				$type = $_GET['type'];
				if($type == "add" || $type == "edit") {
					if($type == "add") {
						$titreAction = 'Ajouter une actualité';
					} elseif($type == "edit") {
						$titreAction = 'Modifier une actualité';
						if(isset($_GET['idNews']) && !empty($_GET['idNews'])) {
							$idNews = htmlspecialchars($_GET['idNews']);
							$readNews = ModelNews::select($idNews);
							if(!$readNews) {
								self::news('<div class="alert alert-danger">Impossible de modifier cette actualité, elle n\'existe pas !</div>');
							}
						} else {
							self::news('<div class="alert alert-danger">Pour pouvoir modifier une actualité il faut son ID</div>');
						}
					}
					$powerNeeded = self::isAdmin();
					$view = 'manageNews';
					$template = 'admin';
					$tab_news = ModelNews::selectAll();
					$pagetitle = 'Administration - '.$titreAction;
					require_once File::build_path(array("view", "main_view.php"));
				} else {
					ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une news !', 'admin');
				}
			} else {
				ControllerDefault::error('Il faut préciser un paramètre de type de gestion de news !', 'admin');
			}
		}

		// Fonction qui permet de générer le formulaire final de suppression d'une news
		public static function deleteNewsForm() {
			self::isAdmin();
			$retour = array(); //Tableau de retour
			if(isset($_POST['idNews'])) {
				$idNews = htmlspecialchars($_POST['idNews']);
				$news = ModelNews::select($idNews);
				if($news != false) {
					$form = '<form method="POST" role="form" action="index.php?controller=adminNews&action=deleteNews">
						<div class="alert alert-info text-center">
							Confirmez vous la suppression de l\'actualité <b>'.htmlspecialchars($news->get('titreNews')).'</b> ?
						</div>
						<input type="hidden" name="idNews" value="'.$news->get('idNews').'">
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
					$retour['message'] = '<div class="alert alert-danger">L\'actualité demandée n\'existe pas !</div>';
				}
			} else {
				$retour['result'] = false;
				$retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
			}
			echo json_encode($retour);
		}

		// Fonction qui supprime une news
		public static function deleteNews() {
			self::isAdmin();
			if(isset($_POST['idNews'], $_POST['confirm'])) {
				$idNews = htmlspecialchars($_POST['idNews']);
				$confirm = htmlspecialchars($_POST['confirm']);
				$news = ModelNews::select($idNews);
				if($news != false) {
					if($confirm == true) {
						$checkDeleteNews = ModelNews::delete($news->get('idNews'));
						if($checkDeleteNews) {
							$message = '<div class="alert alert-success">L\'actualité a bien été supprimé !</div>';
						} else {
							$message = '<div class="alert alert-danger">Impossible de supprimer cette actualité !</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Cette actualité n\'existe pas</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
			}
			self::news($message);
		}

		// Fonction qui ajoute une news
		public static function addNews() {
			self::isAdmin();
			if(isset($_POST['titreNews'],$_POST['contenuNews'],$_POST['dateNews'],$_POST['etatNews'])) {
				$titreNews = htmlspecialchars($_POST['titreNews']);
				$contenuNews = htmlspecialchars($_POST['contenuNews']);
				$dateNews = htmlspecialchars($_POST['dateNews']);
				$etatNews = htmlspecialchars($_POST['etatNews']);
				if(!empty($titreNews) && !ctype_space($titreNews)) {
					if(!empty($contenuNews) && !ctype_space($contenuNews)) {
						if(!empty($dateNews) && !ctype_space($dateNews)) {
							if(DateTime::createFromFormat('Y-m-d', $dateNews) !== false) {
								if($etatNews != 0 && $etatNews != 1) {
									$etatNews = 0; // On force la non-publication.
								}
								$data = array(
									'idNews' => NULL,
									'titreNews' => $titreNews,
									'contenuNews' => $contenuNews,
									'dateNews' => $dateNews,
									'etatNews' => $etatNews
								);
								$testSaveNews = ModelNews::save($data);
								if($testSaveNews) {
									$message = '<div class="alert alert-success">L\'actualité a bien été ajoutée !</div>';
									self::news($message);
									exit(); // On ne veut pas que le code self::manageNews s'exécute :)
								} else {
									$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Vous devez saisir une date d\'actualité non vide</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez saisir un contenu d\'actualité non vide</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous devez saisir un titre d\'actualité non vide</div>';
				}
			}
			self::manageNews($message);
		}

		public static function editNews() {
			self::isAdmin();
			if(isset($_POST['idNews'], $_POST['titreNews'],$_POST['contenuNews'],$_POST['dateNews'],$_POST['etatNews'])) {
				$idNews = htmlspecialchars($_POST['idNews']);
				$titreNews = htmlspecialchars($_POST['titreNews']);
				$contenuNews = htmlspecialchars($_POST['contenuNews']);
				$dateNews = htmlspecialchars($_POST['dateNews']);
				$etatNews = htmlspecialchars($_POST['etatNews']);
				$checkNews = ModelNews::select($idNews);
				if($checkNews) {
					if(!empty($titreNews) && !ctype_space($titreNews)) {
						if(!empty($contenuNews) && !ctype_space($contenuNews)) {
							if(!empty($dateNews) && !ctype_space($dateNews)) {
								if(DateTime::createFromFormat('Y-m-d', $dateNews) !== false) {
									$etatNews = intval($etatNews);
									if($etatNews != 0 && $etatNews != 1) {
										$etatNews = 0; // On force la non-publication.
									}
									$data = array(
										'idNews' => $idNews,
										'titreNews' => $titreNews,
										'contenuNews' => $contenuNews,
										'dateNews' => $dateNews,
										'publie' => $etatNews
									);
									$testSaveNews = ModelNews::update_gen($data, 'idNews');
									if($testSaveNews) {
										$message = '<div class="alert alert-success">L\'actualité a bien été modifiée !</div>';
										self::news($message);
										exit(); // On ne veut pas que le code self::manageNews s'exécute :)
									} else {
										$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
									}
								} else {
									$message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">Vous devez saisir une date d\'actualité non vide</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Vous devez saisir un contenu d\'actualité non vide</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Vous devez saisir un titre d\'actualité non vide</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">L\'actualité que vous tentez de modifier n\'existe pas</div>';
				}
			}
			self::manageNews($message);
		}
	}
?>