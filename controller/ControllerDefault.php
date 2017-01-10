<?php

	/**
	 * This generic class contains all functions that a controller can use
	*/
	class ControllerDefault {
		protected static $object = 'default';

		public static function index() {
			$view = 'index';
			$pagetitle = 'MyGuestHouse';
			$powerNeeded = true;

			$imagesSlides = ModelSlides::selectAll();
			$dataSlides = array();
			if(!empty($imagesSlides)) {
				foreach ($imagesSlides as $slide) {
					$dataSlides[$slide->get('idSlide')] = array(
						'order' => $order,
						'url' => $slide->get('urlSlide'),
						'texte' => htmlspecialchars($slide->get('textSlide'))
					);
					$order++;
				}
			}

			$display_news = ModelOption::selectCustom('nameOption', 'display_news')[0]->get('valueOption');
			if(empty($display_news) && ($display_news != 'true' || $display_news != 'false')) {
				$display_news = 'true';
			}

			if($display_news == 'true') {
				$listNews = ModelNews::getNews(4);
			}

			$listChambres = ModelChambre::selectAll();

			require File::build_path(array('view', 'main_view.php'));
		}

		public static function truncate($text, $chars = 25) {
			$text = $text." ";
			$text = substr($text,0,$chars);
			$text = substr($text,0,strrpos($text,' '));
			$text = $text."...";
			return $text;
		}

		/**
		 * Active ...
		 * Control if the part of the URL who called the controller ask the good controller with the good action
		 *
		 * @param string current controller
		 * @param string current action
		 * @param string current mode (for nav liste with mode)
		 * @return boolean
		*/
		public static function active($currentController = null, $currentAction = null, $currentMode = null, $page = null){
			$queryString = $_SERVER['QUERY_STRING'];
			if($currentMode != null){
				if(strpos($queryString, 'controller='.$currentController.'&action='.$currentAction.'&mode='.$currentMode) !== false) {
					echo 'class="active"';
				}
			} elseif(!empty($currentAction) && $currentAction != null) {
				if(strpos($queryString, 'controller='.$currentController.'&action='.$currentAction) !== false) {
					echo 'class="active"';
				}
			} elseif(!empty($page) && $page != null) {
				if($page == basename($_SERVER['PHP_SELF']) && empty($queryString)) {
					echo 'class="active"';
				}
			} else {
				if($currentAction == NULL && $currentMode == NULL) {
					if(isset($_GET['controller']) && $_GET['controller'] == $currentController) {
						echo 'class="active"';
					}
				} else {
					if(strpos($queryString, 'controller='.$currentController !== false)) {
						echo 'class="active"';
					}
					if ($currentController == 'index' && empty($queryString)) {
						echo 'class="active"';
					}
				}
			}
		}

		public static function ColorDarken($color, $dif=20){
			$color = str_replace('#', '', $color);
			if (strlen($color) != 6){ return '000000'; }
			$rgb = '';

			for ($x=0;$x<3;$x++){
				$c = hexdec(substr($color,(2*$x),2)) - $dif;
				$c = ($c < 0) ? 0 : dechex($c);
				$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
			}

			return '#'.$rgb;
		}

		public static function checked($a, $b) {
			if($a == $b) {
				return 'checked';
			}
		}

		public static function install() {
			$step = isset( $_GET['step'] ) ? (int) $_GET['step'] : 0;
			if(file_exists(File::build_path(array('config', 'Conf.php')))) {
				if(Conf::$installed == false && !isset($_POST['forcestep'])) {
					// On doit installer les tables à présent
					$step = 2;
				}
			}
			switch($step) {
				case 0:
					$view = 'install_0';
				break;
				case 1:
					if(isset($_POST['dbname'], $_POST['uname'], $_POST['pwd'], $_POST['host'])) {
						$dbname = htmlspecialchars($_POST['dbname']);
						$uname = htmlspecialchars($_POST['uname']);
						$pwd = $_POST['pwd'];
						$host = $_POST['host'];
						if(!empty($dbname) && !ctype_space($dbname)) {
							if(!empty($uname) && !ctype_space($uname)) {
								if(!ctype_space($pwd)) {
									if(!empty($host) && !ctype_space($host)) {
										try {
											$pdo = new PDO("mysql:host=$host;dbname=$dbname",$uname,$pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
											$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
											if(is_writable(File::build_path(array('config')))) {
												$config_file = fopen(File::build_path(array('config', 'Conf.php')), 'x+');
												if(!$config_file) {
													$message = '<div class="alert alert-danger">Merci de mettre les permissions totales au dossier config/ afin de poursuivre l\'installation</div>';
													fclose($config_file);
													exit();
												}
												$contentToWrite = "<?php
class Conf {
	static private \$databases = array (
		'hostname' => '".$host."',
		'database' => '".$dbname."',
		'login' => '".$uname."',
		'password' => '".$pwd."'
	);

	static private \$debug = true;

	static public \$theme = 'default';

	static public \$installed = false;

	static public \$power = array(
		'admin' => 100,
		'membre' => 10,
		'visiteur' => 0
	);

	static public function getHostname() {
		return self::\$databases['hostname'];
	}

	static public function getDatabase() {
		return self::\$databases['database'];
	}

	static public function getLogin() {
		return self::\$databases['login'];
	}

	static public function getPassword() {
		return self::\$databases['password'];
	}

	static public function getDebug() {
		return self::\$debug;
	}
}
?>";
												if (fwrite($config_file, $contentToWrite) == FALSE) {
													$message = '<div class="alert alert-danger">Merci de mettre les permissions totales au dossier config/ afin de poursuivre l\'installation</div>';
													fclose($config_file);
													exit();
												}
												fclose($config_file);
											} else {
												$message = '<div class="alert alert-danger">Merci de mettre les permissions totales au dossier config/ afin de poursuivre l\'installation</div>';
											}
										} catch(PDOException $e) {
											$message = '<div class="alert alert-danger">Impossible de se connecter à votre base de données, merci de vérifier les informations saisies !</div>';
										}
										$view = 'install_1';
									} else {
										$message = '<div class="alert alert-danger">Vous devez préciser l\'hote de votre base de données</div>';
									}
								} else {
									$message = '<div class="alert alert-danger">Vous devez préciser le mot de passe de votre base de données</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">Vous devez préciser le nom d\'utilisateur de votre base de données</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Vous devez préciser le nom de votre base de données</div>';
						}
					} else {
						$message = '<div class="alert alert-danger">Merci de remplir tout le formulaire !</div>';
					}
					// Erreur détectée, on retourne avant !
					if(isset($message) && !empty($message)) {
						$view = 'install_0';
					} else {
						$view = 'install_1';
					}
				break;
				case 2:
					if(file_exists(File::build_path(array('config', 'Conf.php')))) {
						// Le fichier config/Conf.php existe et doit exister, la variable Conf::$installed doit valoir "false", car l'installation n'a pas été effectuée !
						// Cela permet aussi de revenir à cette étape si l'on abandonne en cours de route.
						try {
							$fileTables = File::build_path(array('MyGuestHouse-TABLES.sql'));

							if(file_exists($fileTables)) {
								$sql = file_get_contents(File::build_path(array('MyGuestHouse-TABLES.sql')));
								$requete = Model::$pdo->exec($sql);
							} else {
								$message = '<div class="alert alert-danger">Impossible de créer les tables, merci de retélécharger le fichier MyGuestHouse-TABLES.sql et de le mettre à la racine du dossier du CMS</div>';
							}
						} catch(PDOException $e) {
							$message = '<div class="alert alert-danger">Impossible d\'effectuer une requête sur votre base de données, merci de nous contacter</div>';
						}
						$view = 'install_2';
					} else {
						$message = '<div class="alert alert-danger">Impossible d\'accéder au fichier de configuration, il faut le recréer</div>';
						$view = 'install_0';
					}
				break;
				case 3:
					if(file_exists(File::build_path(array('config', 'Conf.php')))) {
						if(isset($_POST['websitename'], $_POST['email'], $_POST['password'], $_POST['prenom'], $_POST['nom'])) {
							$websitename = htmlspecialchars($_POST['websitename']);
							$email = htmlspecialchars($_POST['email']);
							$prenom = htmlspecialchars($_POST['prenom']);
							$nom = htmlspecialchars($_POST['nom']);
							$password = $_POST['password'];
							if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
								if(!empty($password) &&  !ctype_space($password)) {
									if(!empty($prenom) && !ctype_space($prenom)) {
										if(!empty($nom) && !ctype_space($nom)) {
											if(!empty($websitename) && !ctype_space($websitename)) {
												$data = array (
													'id' => NULL,
													'prenom' => $prenom,
													'nom' => $nom,
													'email' => $email,
													'password' => password_hash($password, PASSWORD_DEFAULT),
													'rang' => 3,
													'nonce' => NULL
												);

												try {
													// Création du compte admin
													$sql = 'INSERT INTO `GH_Utilisateurs` VALUES (:id, :prenom, :nom, :email, :password, :rang, :nonce)';
													$addAdminAccount = Model::$pdo->prepare($sql);
													$addAdminAccount->execute($data);
													// Ajout des options principales du site
													$sql = 'INSERT INTO `GH_Options` VALUES (:idOption, :nameOption, :valueOption)';
													// Insertion du nom du site
													$data = array(
														'idOption' => NULL,
														'nameOption' => 'nom_site',
														'valueOption' => $websitename
													);
													$addOption = Model::$pdo->prepare($sql);
													$addOption->execute($data);
													// Ajout de la news par défaut
													$sql = 'INSERT INTO `GH_News` VALUES (:idNews, :titreNews, :contenuNews, :dateNews, :publie)';
													// Insertion du nom du site
													$contenuNews = "[grand]Bienvenue à vous ![/grand]
													L'installation est un grand [b]succès ![/b]
													Vous pouvez maintenant accéder à  [lien url=index.php?controller=admin&amp;action=index]l'administration[/lien] avec le compte crée lors de l'installation et supprimer cette actualité de présentation.

													[liste titre=Ma liste][li]Item 1[/li][li]Item 2[/li][li]Item 3[/li][/liste]

													[b][u]Exemple de BBCODE :[/u][/b]
													[b]Gras[/b]
													[i]Italique[/i]
													[u]Souligné[/u]
													[lien url=https://google.fr/]Lien[/lien]
													[grand]Grand[/grand]
													[moyen]Moyen[/moyen]
													[petit]Petit[/petit]";
													$data = array(
														'idNews' => NULL,
														'titreNews' => 'Bienvenue sur MyGuestHouse',
														'contenuNews' => $contenuNews,
														'dateNews' =>, date('Y-m-d')
														'publie' => 1
													);
													$addNews = Model::$pdo->prepare($sql);
													$addNews->execute($data);
													// Maintenant il faut passer le $installed dans Conf à true.
													$path_to_file = File::build_path(array('config', 'Conf.php'));
													$file_contents = file_get_contents($path_to_file);
													$file_contents = str_replace("static public \$installed = false;", "static public \$installed = true;",$file_contents);
													$testToModify = file_put_contents($path_to_file, $file_contents);
													if($testToModify === FALSE) {
														$message = '<div class="alert alert-danger">Merci d\'éditer le fichier config/Conf.php et de passer $installed à true</div>';
													}
												} catch(PDOException $e) {
													$message = '<div class="alert alert-danger">Une erreur SQL est survenue, merci de nous contacter !</div>';
												}
											} else {
												$message = '<div class="alert alert-danger">Vous devez renseigner un nom de site</div>';
											}
										} else {
											$message = '<div class="alert alert-danger">Vous devez renseigner le nom du compte administrateur</div>';
										}
									} else {
										$message = '<div class="alert alert-danger">Vous devez renseigner le prénom du compte administrateur</div>';
									}
								} else {
									$message = '<div class="alert alert-danger">Le compte administrateur doit posséder un mot de passe</div>';
								}
							} else {
								$message = '<div class="alert alert-danger">L\'adresse e-mail renseignée est dans un format incorrect, assurez-vous d\'avoir saisi une adresse e-mail valide</div>';
							}
						} else {
							$message = '<div class="alert alert-danger">Merci de remplir tout le formulaire !</div>';
						}
						// Erreur détectée, on retourne avant !
						if(isset($message) && !empty($message)) {
							$view = 'install_2';
						} else {
							session_unset(); // Installation réussie
							$view = 'install_3';
						}
					} else {
						$message = '<div class="alert alert-danger">Impossible d\'accéder au fichier de configuration, il faut le recréer</div>';
						$view = 'install_0';
					}
				break;
			}
			require File::build_path(array('view', 'default', 'install.php'));
		}


		/**
		 *
		*/
		public static function error($error, $template = NULL) {
			$displayError = $error;
			$view = 'error';
			$pagetitle= 'MyGuestHouse - Erreur';
			$powerNeeded = true;
			require File::build_path(array('view', 'main_view.php'));
		}
	}
?>