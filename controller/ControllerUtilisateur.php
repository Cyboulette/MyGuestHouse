<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelOption.php'));

class ControllerUtilisateur {

	protected static $object = 'utilisateur';

   // Affichage du formulaire de connexion
   public static function connect() {
      $view = 'connexion';
      $pagetitle = 'Se connecter';
      $powerNeeded = !self::isConnected();

      require File::build_path(array('view', 'main_view.php'));
   }

   // Essaye de connecter un utilisateur
   public static function connected() {
      $titlePage = "Se connecter";
      if(!self::isConnected()) {
         if(isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $email = strip_tags($_POST['email']);
            $password = strip_tags($_POST['password']);

            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $checkUser = ModelUtilisateur::selectCustom('emailUtilisateur', $email);
               if($checkUser != false) {
                  if($checkUser[0]->get('nonce') == null) {
                     if(password_verify($password, $checkUser[0]->get('password'))) {
                        $_SESSION['login'] = true;
                        $_SESSION['idUser'] = $checkUser[0]->get('idUtilisateur');
                        $message = 'Connexion réalisée avec succès !';
                        $view = 'success_action';
                        $pagetitle = 'Connexion réussie';
                        $powerNeeded = self::isConnected();
                        require File::build_path(array('view', 'main_view.php'));
                     } else {
                        ModelUtilisateur::errorForm('Le mot de passe est incorrect', 'connexion', $titlePage);
                     }
                  } else {
                     ModelUtilisateur::errorForm('Vous devez valider votre adresse email en cliquant sur le lien qui vous a été envoyé par mail', 'connexion', $titlePage);
                  }
               } else {
                  ModelUtilisateur::errorForm('Cette adresse e-mail ne correspond à aucun compte !', 'connexion', $titlePage);
               }
            } else {
               ModelUtilisateur::errorForm('L\'adresse e-mail renseignée est invalide !', 'connexion', $titlePage);
            }
         } else {
            ModelUtilisateur::error('Vous devez renseigner tous les champs !');
         }
      } else {
         ModelUtilisateur::error('Vous êtes déjà connecté !');
      }
   }

   // Essaye de déconnecter un utilisateur
   public static function disconnect() {
      if(self::isConnected()) {
         unset($_SESSION['login']);
         unset($_SESSION['idUser']);
         $message = 'Déconnexion réalisée avec succès !';
         $view = 'success_action';
         $pagetitle = 'Déconnexion';
         $powerNeeded = !self::isConnected();
         require File::build_path(array('view', 'view.php'));
      } else {
         ModelUtilisateur::error('Vous n\'êtes pas connecté, impossible de vous déconnecter !');
      }
   }

   // Affichage du formulaire d'inscription
   public static function register() {
      $view = 'register';
      $pagetitle = 'S\'inscrire';
      $powerNeeded = !self::isConnected();
      require File::build_path(array('view', 'main_view.php'));
   }

   // Essaye d'inscrire un utilisateur
   public static function registered() {
      $titlePage = "S'inscrire";
      if(!self::isConnected()) {
         if(isset($_POST['email'],$_POST['password'],$_POST['password_confirm'],$_POST['prenom'], $_POST['nom'])) {
            $email = strip_tags($_POST['email']);
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $checkUser = ModelUtilisateur::selectCustom('emailUtilisateur', $email);
               if($checkUser == false) {
                  $password = strip_tags($_POST['password']);
                  $password_confirm = strip_tags($_POST['password_confirm']);
                  if(!empty($password) &&  !ctype_space($password)) {
                     if($password_confirm == $password) {
                        $prenom = strip_tags($_POST['prenom']);
                        if(!empty($prenom) && !ctype_space($prenom)) {
                           $nom = strip_tags($_POST['nom']);
                           if(!empty($nom) && !ctype_space($nom)) {
                              $data = array (
                                 'idUtilisateur' => NULL,
                                 'prenomUtilisateur' => $prenom,
                                 'nomUtilisateur' => $nom,
                                 'emailUtilisateur' => $email,
                                 'password' => password_hash($password, PASSWORD_DEFAULT),
                                 'rang' => 2,
                                 'nonce' => ModelUtilisateur::generateRandomHex()
                              );

                              $resultSave = ModelUtilisateur::save($data);
                              //ENVOYER MAIL ICI
                              if($resultSave) {
                                 $message = 'Inscription réalisée avec succès !';
                                 $view = 'success_action';
                                 $pagetitle = 'Inscription';
                                 $powerNeeded = !self::isConnected();
                                 require File::build_path(array('view', 'main_view.php'));
                              } else {
                                 ModelUtilisateur::errorForm('Impossible de vous inscrire, merci de nous contacter', 'register', $titlePage);
                              }
                           } else {
                              ModelUtilisateur::errorForm('Vous devez saisir votre nom', 'register', $titlePage);
                           }
                        } else {
                           ModelUtilisateur::errorForm('Vous devez saisir votre prénom', 'register', $titlePage);
                        }
                     } else {
                        ModelUtilisateur::errorForm('Les mots de passe ne correspondent pas', 'register', $titlePage);
                     }
                  } else {
                     ModelUtilisateur::errorForm('Vous ne pouvez pas avoir un mot de passe vide !', 'register', $titlePage);
                  }
               } else {
                  ModelUtilisateur::errorForm('Cette adresse e-mail est déjà inscrite sur notre site', 'register', $titlePage);
               }
            } else {
               ModelUtilisateur::errorForm('Vous devez saisir une adresse e-mail valide !', 'register', $titlePage);
            }
         } else {
            ModelUtilisateur::error('Merci de saisir tous les champs !');
         }
      } else {
         ModelUtilisateur::error('Vous ne pouvez pas vous inscrire en étant déjà connecté !');
      }
   }

   // Valide l'adresse e-mail après une inscription
   public static function validate() {
      $titlePage = 'Valider son inscription';
      if(isset($_GET['key'], $_GET['email'])) {
         $key = strip_tags($_GET['key']);
         $email = strip_tags($_GET['email']);
         if(!empty($key) && !empty($email)) {
            $checkUser = ModelUtilisateur::selectCustom('emailUtilisateur', $email);
            if($checkUser != false) {
               $user = $checkUser[0];
               if($key == $user->get('nonce')) {
                  $checkUpdate = $user->validate();
                  if($checkUpdate) {
                     $message = 'Validation de votre e-mail réalisée avec succès !';
                     $view = 'success_action';
                     $pagetitle = 'Validation de l\'adresse e-mail';
                     $powerNeeded = !self::isConnected();
                     require File::build_path(array('view', 'view.php'));
                  } else {
                     ModelUtilisateur::error('Impossible de valider votre adresse e-mail, veuillez nous contacter');
                  }
               } else {
                  ModelUtilisateur::error('Cette clé de validation est invalide !');
               }
            } else {
               ModelUtilisateur::error('Ce mail n\'est pas inscrit sur notre site !');
            }
         } else {
            ModelUtilisateur::error('Impossible de valider sans recevoir les données');
         }
      } else {
         ModelUtilisateur::error('Impossible de valider sans recevoir les données');
      }
   }

   // Détermine si un utilisateur est connecté ou non
   public static function isConnected() {
      if(isset($_SESSION['login'], $_SESSION['idUser'])) {
         return true;
      } else {
         return false;
      }
   }

   public static function checkRang($rang) {
      if(self::isConnected()) {
         $userConnected = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser']);
         if($userConnected != false) {
            $user = $userConnected[0];
            return $user->getInfosRang();
         } else {
            return 0;
         }
      } else {
         return 0;
      }
   }

   public static function selectAllRéservation(){

   }

}
?>