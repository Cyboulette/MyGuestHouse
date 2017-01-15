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
			if(!empty($currentAction) && $currentAction != null) {
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
					if($currentMode != null && isset($_GET['mode']) && $currentMode == $_GET['mode']) {
						echo 'class="active"';
					}
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
														'dateNews' => date('Y-m-d'),
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

		public static function error($error, $template = NULL) {
			$displayError = $error;
			$view = 'error';
			$pagetitle= 'MyGuestHouse - Erreur';
			$powerNeeded = true;
			require File::build_path(array('view', 'main_view.php'));
		}


		/* SOME VERIFICATION'S FUNCTIONS */

		/**
		 * @param string the date of the begining
		 * @param string the date of the end
		 * @param int the id of the chambre
		 * @return array
		 */
		public static function verifToDatesDisabled($date1, $date2, $idChambre){
			$tab_reservations = ModelReservation::selectAllDateByChambre($idChambre);
			$nombreJour = ControllerDefault::getDiffJours($date1, $date2);
			$result = array();
			for ($nombre = 0 ; $nombre < $nombreJour ; $nombre ++) {
				$dateTime = ControllerDefault::getDateTime($date1);
				$dateTime->modify("+".$nombre." day");
				$dateTime = $dateTime->format("d/m/Y");
				array_push($result, $dateTime);
			}

			return array_intersect($result, $tab_reservations) == null;
		}

		/**
		 * @param $idReservation
		 * @return mixed the id of the user who reserve the reservation n° $idReservation
		 */
		public static function idUserForReservation($idReservation) {
			$reservationUser = ModelReservation::select($idReservation);
			$idUser = $reservationUser->get('idUtilisateur');

			return $idUser;
		}

		/**
		 * @param $idReservation
		 * @return array
		 */
		public static function verifReservationExist($idReservation) {
			$reservations = ModelReservation::selectAll();
			$idReservationToArray = array($idReservation);
			$idReservationsAll = array();


			foreach($reservations as $reservation){
				array_push($idReservationsAll, strval($reservation->get('idReservation')));
			}

			// Si c'est une reservation qui fait partie des reservations de l'utilisateur on renvoie true
			return array_intersect($idReservationToArray, $idReservationsAll);
		}


		/* SOME FUNCTION FOR RESERVATION'S DATE */

		/**
		 * @param $string the date with the format : d/m/Y
		 * @return DateTime
		 */
		public static function getDateTime($string){
			$dayFin = $string[0] . $string[1];
			$monthFin = $string[3] . $string[4];
			$yearFin = $string[6] . $string[7] . $string[8] . $string[9];

			$dateTime = new DateTime();
			return $dateTime->setDate($yearFin, $monthFin, $dayFin);
		}

		/**
		 * @param $dateDebut
		 * @param $dateFin
		 * @return array Return the 2 dates with the format 'Y-d-m' with 'dateDebut' and 'dateFin' index
		 */
		public static function getDateForBdFormat($dateDebut, $dateFin){
			$dayDebut = $dateDebut[0] . $dateDebut[1];
			$monthDebut = $dateDebut[3] . $dateDebut[4];
			$yearDebut = $dateDebut[6] . $dateDebut[7] . $dateDebut[8] . $dateDebut[9];

			$dayFin = $dateFin[0] . $dateFin[1];
			$monthFin = $dateFin[3] . $dateFin[4];
			$yearFin = $dateFin[6] . $dateFin[7] . $dateFin[8] . $dateFin[9];

			$dateDebut = new DateTime();
			$dateFin = new DateTime();

			$dateDebut->setDate($yearDebut, $monthDebut, $dayDebut);
			$dateFin->setDate($yearFin, $monthFin, $dayFin);

			$dateDebut = $dateDebut->format('Y-m-d');
			$dateFin = $dateFin->format('Y-m-d');

			$result = Array(
				"dateDebut" => $dateDebut,
				"dateFin" => $dateFin
			);

			return $result;
		}

		/**
		 * @param $getDate
		 * @return string Return the current date or any else date (with the same format of getDate() object) convert to the french format
		 */
		public static function getCurrentDateForDatePicker($getDate = null){
			$zeroDay = null;
			$zeroMonth = null;
			if($getDate === null){
				$getDate = getDate();
			}

			// Gestion des 0 qu'il faut rajouter
			if(intval($getDate['mday']) < 10){
				$zeroDay = 0;
			} elseif (intval($getDate['mon']) < 10) {
				$zeroMonth = 0;
			}


			return $zeroDay.$getDate['mday'].'/'.$zeroMonth.$getDate['mon'].'/'.$getDate['year'];
		}


		/* Some usefull functions */


		/**
		 * @param $date1 the date with the format d/m/Y
		 * @param $date2 the date with the format d/m/Y
		 * @return int|null
		 */
		public static function getDiffJours($date1, $date2){
			$dates = ControllerDefault::getDateForBdFormat($date1, $date2);
			$datetime1 = date_create($dates['dateDebut']);
			$datetime2 = date_create($dates['dateFin']);
			$interval = intval(date_diff($datetime1, $datetime2)->format("%R%a"));

			if($interval < 0){
				return $interval;
			} else {
				return $interval;
			}
		}

		/**
		 * @param $dateDebut the date with the format Y-m-d
		 * @param $dateFin	the date with the format Y-m-d
		 * @return int|null
		 */
		public static function getDiffNuitsWithBDFormat($dateDebut, $dateFin) {
			$datetime1 = new DateTime($dateDebut);
			$datetime2 = new DateTime($dateFin);
			$interval = intval(date_diff($datetime1, $datetime2)->format("%R%a"));

			if($interval < 0){
				return $interval;
			} else {
				return $interval;
			}
		}

		/**
		 * @param object a list of php object
		 * @return mixed the last object in $listObject
		 */
		public static function getLastObject(Array $listObject){
			if($listObject === null ) {
				return null;
			}
			$result = null;
			foreach ($listObject as $object) {
				$result = $object;
 			}
			return $result;
		}




		// Est-ce que ces fonctions sont inutiles ?
		/**
		 * @param $dateDebut
		 * @param $dateFin
		 * @return int the difference between the 2 dates in days
		 */
		public static function getNombreNuits($dateDebut, $dateFin){
			$dayDebut = intval($dateDebut[0] . $dateDebut[1]);
			$monthDebut = intval($dateDebut[3] . $dateDebut[4]);
			$yearDebut = intval($dateDebut[6] . $dateDebut[7] . $dateDebut[8] . $dateDebut[9]);

			$dayFin = intval($dateFin[0] . $dateFin[1]);
			$monthFin = intval($dateFin[3] . $dateFin[4]);
			$yearFin = intval($dateFin[6] . $dateFin[7] . $dateFin[8] . $dateFin[9]);

			$nombreJour1 = ControllerDefault::getNombreNuitsMois($monthDebut) + $dayDebut;
			$nombreJour2 = ControllerDefault::getNombreNuitsMois($monthFin) + $dayFin;

			$result = $nombreJour2 - $nombreJour1;

			return $result;
		}

		/** TODO : à revoir
		 * @param $mois
		 * @return int
		 */
		public static function getNombreNuitsMois($mois){
			$result = 0;
			switch ($mois) {
				case 1:
					return 31;
					break;
				case 2:
					return 31+29;
					break;
				case 3:
					return 31+29+31;
					break;
				case 4:
					return 31+29+31+30;
					break;
				case 5:
					return 31+29+31+30+31;
					break;
				case 6:
					return 31+29+31+30+31+30;
					break;
				case 7:
					return 31+29+31+30+31+30+31;
					break;
				case 8:
					return 31+29+31+30+31+30+31+31;
					break;
				case 9:
					return 31+29+31+30+31+30+31+31+30;
					break;
				case 10:
					return 31+29+31+30+31+30+31+31+30+31;
					break;
				case 11:
					return 31+29+31+30+31+30+31+31+30+31+30;
					break;
				case 12:
					return 31+29+31+30+31+30+31+31+30+31+30+31;
					break;
			}
			return $result;
		}
	}
?>