<?php
class ControllerAdminSlides extends ControllerAdmin {
	// Fonction qui permet de lister les news
	public static function slides($message = NULL) {
		$powerNeeded = self::isAdmin();
		$view = 'listSlides';
		$pagetitle = 'Administration - Gestion des images défilantes';
		$template = 'admin';
		$tab_slides = ModelSlides::selectAll();
		require_once File::build_path(array("view", "main_view.php"));
	}

	// Fonction qui permet de gérer les slides (ajout ou modification)
	public static function manageSlides($message = NULL) {
		if(isset($_GET['type'])) {
			$type = $_GET['type'];
			if($type == "add" || $type == "edit") {
				if($type == "add") {
					$titreAction = 'Ajouter une image défilante';
				} elseif($type == "edit") {
					$titreAction = 'Modifier une image défilante';
					if(isset($_GET['idSlide']) && !empty($_GET['idSlide'])) {
						$idSlide = htmlspecialchars($_GET['idSlide']);
						$readSlide = ModelSlides::select($idSlide);
						if(!$readSlide) {
							self::news('<div class="alert alert-danger">Impossible de modifier cette image, elle n\'existe pas !</div>');
						}
					} else {
						self::news('<div class="alert alert-danger">Pour pouvoir modifier une image il faut son ID</div>');
					}
				}
				$powerNeeded = self::isAdmin();
				$view = 'manageSlides';
				$template = 'admin';
				$tab_slides = ModelSlides::selectAll();
				$pagetitle = 'Administration - '.$titreAction;
				require_once File::build_path(array("view", "main_view.php"));
			} else {
				ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une image !', 'admin');
			}
		} else {
			ControllerDefault::error('Il faut préciser un paramètre de type de gestion des images !', 'admin');
		}
	}

	// Fonction qui ajoute une slide
	public static function addSlide() {
		self::isAdmin();
		if(isset($_POST['urlSlide']) || isset($_FILES['urlSlide'])) {
			if(isset($_FILES['urlSlide']) && !empty($_FILES['urlSlide']['name'])) {
				$image = $_FILES['urlSlide'];
				$extensionsOK = array('jpg', 'jpeg', 'gif', 'png');
				$extensionUpload = strtolower(substr(strrchr($image['name'], '.'), 1));
				if (in_array($extensionUpload, $extensionsOK)) {
					$dir = "assets/images/slides/image_upload_" . time() . ".png";
					$resultat = move_uploaded_file($image['tmp_name'], $dir);
					if($resultat) {
						$urlSlide = $dir;
					} else {
						$message = '<div class="alert alert-danger">Impossible d\'ajouter l\'image, veuillez réessayer</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Assurez-vous d\'envoyer une image au format : jpg ou png ou gif</div>';
				}
			} else {
				$urlSlide = htmlspecialchars($_POST['urlSlide']);
			}
			if(!isset($message) && empty($message) && isset($urlSlide) && !empty($urlSlide) && !ctype_space($urlSlide)) {
				if(isset($_POST['textSlide']) && !empty($_POST['textSlide']) && !ctype_space($_POST['textSlide'])) {
					$textSlide = htmlspecialchars($_POST['textSlide']);
				} else {
					$textSlide = NULL;
				}
				$nameImage = str_replace("assets/images/slides/", "", $urlSlide);

				$data = array(
					'idSlide' => NULL,
					'urlSlide' => $urlSlide,
					'textSlide' => $textSlide
				);
				$testSaveSlide = ModelSlides::save($data);
				if($testSaveSlide) {
					$message = '<div class="alert alert-success">L\'image a bien été ajoutée !</div>';
					self::slides($message);
					exit(); // On ne veut pas que le code self::manageNews s'exécute :)
				} else {
					$urlVerify = File::build_path(array('assets', 'images', 'slides', $nameImage));
					if(file_exists($urlVerify)) {
						unlink($urlVerify);
					}
					$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
				}
			}
		} else {
			$message = '<div class="alert alert-danger">Aucune donnée transmise</div>';
		}
		self::manageSlides($message);
	}

	// Fonction qui édite une slide
	public static function editSlide() {
		self::isAdmin();
		if(isset($_POST['urlSlide']) || isset($_FILES['urlSlide']) && isset($_POST['idSlide'])) {
			$idSlide = htmlspecialchars($_POST['idSlide']);
			$getSlide = ModelSlides::select($idSlide);
			if($getSlide != false) {
				if(isset($_FILES['urlSlide']) && !empty($_FILES['urlSlide']['name'])) {
					$image = $_FILES['urlSlide'];
					$extensionsOK = array('jpg', 'jpeg', 'gif', 'png');
					$extensionUpload = strtolower(substr(strrchr($image['name'], '.'), 1));
					if (in_array($extensionUpload, $extensionsOK)) {
						$dir = "assets/images/slides/image_upload_" . time() . ".png";
						$resultat = move_uploaded_file($image['tmp_name'], $dir);
						if($resultat) {
							$urlSlide = $dir;
						} else {
							$message = '<div class="alert alert-danger">Impossible d\'ajouter l\'image, veuillez réessayer</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Assurez-vous d\'envoyer une image au format : jpg ou png ou gif</div>';
					}
				} else {
					$urlSlide = htmlspecialchars($_POST['urlSlide']);
				}
				if(!isset($message) && empty($message) && isset($urlSlide) && !empty($urlSlide) && !ctype_space($urlSlide)) {
					if(isset($_POST['textSlide']) && !empty($_POST['textSlide']) && !ctype_space($_POST['textSlide'])) {
						$textSlide = htmlspecialchars($_POST['textSlide']);
					} else {
						$textSlide = NULL;
					}
					$nameImage = str_replace("assets/images/slides/", "", $urlSlide);

					$data = array(
						'idSlide' => $idSlide,
						'urlSlide' => $urlSlide,
						'textSlide' => $textSlide
					);
					$testUpdateSlide = ModelSlides::update_gen($data, 'idSlide');
					if($testUpdateSlide) {
						$message = '<div class="alert alert-success">L\'image a bien été modifiée !</div>';
						self::slides($message);
						exit(); // On ne veut pas que le code self::manageNews s'exécute :)
					} else {
						$urlVerify = File::build_path(array('assets', 'images', 'slides', $nameImage));
						if(file_exists($urlVerify)) {
							unlink($urlVerify);
						}
						$message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
					}
				}
			} else {
				$message = '<div class="alert alert-danger">Cette image défilante n\'existe pas !</div>';
			}
		} else {
			$message = '<div class="alert alert-danger">Vous devez transmettre l\'id de l\'image à éditer</div>';
		}
		self::manageSlides($message);
	}

	public static function preDeleteItem() {
		self::deleteItemForm("adminSlides", "ModelSlides", "de l'image", "urlSlide", 'idSlide');
	}

	public static function deleteItem() {
		self::isAdmin();
		if(isset($_POST['idItem'], $_POST['confirm'])) {
			$idSlide = htmlspecialchars($_POST['idItem']);
			$confirm = htmlspecialchars($_POST['confirm']);
			$slide = ModelSlides::select($idSlide);
			if($slide != false) {
				if($confirm == true) {
					$checkDeleteSlide = ModelSlides::delete($slide->get('idSlide'));
					if($checkDeleteSlide) {
						$urlImage = $slide->get('urlSlide');
						$firstChars = substr($urlImage, 0, 6);
						$nameImage = str_replace("assets/images/slides/", "", $urlImage);
						if($firstChars == "assets") {
							$fileUrl = File::build_path(array('assets', 'images', 'slides', $nameImage));
							if(file_exists($fileUrl)) {
								unlink($fileUrl);
							}
						}
						$message = '<div class="alert alert-success">L\'image a bien été supprimé !</div>';
					} else {
						$message = '<div class="alert alert-danger">Impossible de supprimer cette image !</div>';
					}
				} else {
					$message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
				}
			} else {
				$message = '<div class="alert alert-danger">Cette image n\'existe pas</div>';
			}
		} else {
			$message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
		}
		self::slides($message);
	}
}
?>