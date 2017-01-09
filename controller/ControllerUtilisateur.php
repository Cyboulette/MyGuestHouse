<?php
/*require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelOption.php'));*/

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
         require File::build_path(array('view', 'main_view.php'));
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

   public static function profil(){
      if(self::isConnected()){
         $utilisateur= ModelUtilisateur::select($_SESSION['idUser']);

         $view = 'displayUser';
         $pagetitle = 'Détail de l\'utilisateur';
         $powerNeeded = true;
         require File::build_path(array('view', 'main_view.php'));
      } else {
         ModelUtilisateur::error('Vous n\'êtes pas connecté, impossible d\'acceder a vos informations !');
      }
   }

   public static function edit(){
      if(self::isConnected()){
         $utilisateur= ModelUtilisateur::select($_SESSION['idUser']);

         $view = 'editUser';
         $pagetitle = 'Détail de l\'utilisateur';
         $powerNeeded = true;
         require File::build_path(array('view', 'main_view.php'));
      } else {
         ModelUtilisateur::error('Vous n\'êtes pas connecté, impossible d\'acceder a la modifictaions de vos informations !');
      }
   }

   public static function edited(){
      if(self::isConnected()){
         $view = 'displayUser';
         $pagetitle = 'Détail de l\'utilisateur';
         $powerNeeded = true;

         if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])){
            if($_POST['nom']!=null && $_POST['prenom']!=null && $_POST['email']!=null){

               $lutilisateur = array(
                  'idUtilisateur' => $_SESSION['idUser'],
                  'emailUtilisateur' => $_POST['email'],
                  'nomUtilisateur' => $_POST['nom'],
                  'prenomUtilisateur' => $_POST['prenom']
               );
               $update = ModelUtilisateur::update_gen($lutilisateur, 'idUtilisateur');
               if($update!=false){
                  $message = '<div class="alert alert-success">Utilisateur modifié avec succès !</div>';
               }else{
                  $message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la mise a jour de l\'utilisateur!</div>';
               }
            }else{
               $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide !</div>';
            }   
         }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par l\'étape de modification !</div>';
         }
         // pour le vue displayUser ---
         $utilisateur= ModelUtilisateur::select($_SESSION['idUser']);
         require File::build_path(array('view', 'main_view.php'));
      }else {
         ModelUtilisateur::error('Vous n\'êtes pas connecté, il vous est donc impossible de modifier vos informations !');
      }
   }

   public static function changePassword(){
      if(self::isConnected()){
         $view = 'displayUser';
         $pagetitle = 'Détail de l\'utilisateur';
         $powerNeeded = true;

         $checkUser = ModelUtilisateur::select($_SESSION['idUser']);

         if(isset($_POST['ancienMDP']) && isset($_POST['nouveauMDP']) && isset($_POST['nouveauMDPbis'])){
            if($_POST['ancienMDP']!=null && $_POST['nouveauMDP']!=null && $_POST['nouveauMDPbis']!=null){
               $ancienMDP = strip_tags($_POST['ancienMDP']);
               $nouveauMDP = strip_tags($_POST['nouveauMDP']);
               $nouveauMDPbis = strip_tags($_POST['nouveauMDPbis']);

               if(password_verify($ancienMDP, $checkUser->get('password'))){
                  if($nouveauMDP == $nouveauMDPbis){
                     $lutilisateur = array(
                        'idUtilisateur' => $_SESSION['idUser'],
                        'password' => password_hash($nouveauMDP, PASSWORD_DEFAULT)
                     );

                     $update = ModelUtilisateur::update_gen($lutilisateur, 'idUtilisateur');
                     if($update!=false){
                        $message = '<div class="alert alert-success">Votre changement de mot de passe a bien été effectué !</div>';
                     }else{
                        $message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la modifictaion de votre mot de passe!</div>';
                     }
                  }else{
                     $message = '<div class="alert alert-danger">L\'a validation du nouveau mot de passe n\'est pas correct !</div>';
                  } 
               }else{
                  $message = '<div class="alert alert-danger">L\'ancien mot de passe est incorrect !</div>';
               }   
            }else{
               $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide !</div>';
            }   
         }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par l\'étape de modification !</div>';
         }
         // pour le vue displayUser ---
         $utilisateur= ModelUtilisateur::select($_SESSION['idUser']);
         require File::build_path(array('view', 'main_view.php'));
      }else {
         ModelUtilisateur::error('Vous n\'êtes pas connecté, il vous est donc impossible de modifier vos informations !');
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

}
?>