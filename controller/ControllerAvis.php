<?php

class ControllerAvis{

	protected static $object = 'avis';


   public static function add(){
      if(ControllerUtilisateur::isConnected()){
         if( isset($_POST['avis'], $_POST['note']) && (isset($_POST['idChambre']) || isset($_POST['forChambre'])) && (isset($_GET['idUtilisateur']) || isset($_POST['idUtilisateur'])) ){

            if (isset($_POST['idChambre'])) {
               $idChambre = htmlspecialchars($_POST['idChambre']);
            }elseif(isset($_POST['forChambre'])){
               $idChambre = htmlspecialchars($_POST['forChambre']);
            }

            if (isset($_GET['idUtilisateur'])) {
               $idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
            }elseif(isset($_POST['idUtilisateur'])){
               $idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
            }

            // echo 'utilisateur : '.$idUtilisateur."<br> chambre = ".$idChambre."<br> avis = ".$_POST['avis'];
            if($idUtilisateur!=null && $_POST['avis']!=null && $idChambre!=null){
               if(is_numeric($_POST['note']) && $_POST['note']>=0 && $_POST['note']<=5){
                  
                  $utilisateur = ModelUtilisateur::select($idUtilisateur);
                  $chambre = ModelChambre::select($idChambre);
                  $avis = ModelAvis::select($idUtilisateur, $idChambre);

                  if(!$avis){
                     if($utilisateur!=false){
                        if($chambre!=false){
                           if(ModelAvis::haveReservedRoom($idUtilisateur, $idChambre)){
                              $avis = htmlspecialchars($_POST['avis']);
                              $note = htmlspecialchars($_POST['note']);

                              $data = array (
                                 'idChambre' => $idChambre,
                                 'idUtilisateur' => $idUtilisateur,
                                 'note' => $note,
                                 'commentaire' => $avis
                              );
                              $resultSave = ModelAvis::save($data);
                              if($resultSave){
                                 $message = '<div class="alert alert-success">Votre avis a été ajouté avec succés !</div>';
                              }else{
                                 $message = '<div class="alert alert-danger">Nous n\'avons pas pu proceder a la sauvegarde de l\'avis !</div>';
                              }
                           }else{
                              $message = '<div class="alert alert-danger">Vous ne pouvez pas emettre d\'avis pour cette chambre !</div>';
                           }
                        }else{
                           $message = '<div class="alert alert-danger">La chambre sur laquelle vous voulez émettre un avis n\'existe plus !</div>';
                        }
                     }else{
                        ControllerDefault::error('Vous n\'avez pas de compte chez nous pour l\'instant !');
                     }
                  }else{
                     $message = '<div class="alert alert-danger">Vous avez deja emis un avis sur cette chambre !</div>';
                  }
               }else{   
                  $message = '<div class="alert alert-danger">Vous devez donner une note entre 0 et 5 (en valeur numerique) !</div>';
               }
            }else{
               $message = '<div class="alert alert-danger">Vous devez renseigner touts les champs afin d\'émettre un avis !</div>';
            }
         }else{
            $message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer vos infomations sur l\'avis !</div>';
         }
         // require File::build_path(array('view', 'main_view.php'));
         if(isset($_GET['forChambre'])){
            if(ModelChambre::select(htmlspecialchars($_GET['forChambre']))){
               ControllerChambre::read($message);
            }else{
               ControllerUtilisateur::profil($message);
            }
         }else{
            ControllerUtilisateur::profil($message);
         }
         
      } else {
         ControllerDefault::error('Vous n\'êtes pas connecté, impossible d\'acceder a la modifictaions de vos informations !');
      }
   }

   public static function edit(){
      if(ControllerUtilisateur::isConnected()){
         if(isset($_GET['idUtilisateur'], $_GET['idChambre']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null ){
         	$idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
            if($idUtilisateur=$_SESSION['idUser']){
            	$idChambre = htmlspecialchars($_GET['idChambre']);
            	$avis = ModelAvis::select($idUtilisateur, $idChambre);
               if($avis!=null){
                  $view = 'editAvis';
                  $pagetitle = 'Modifiez votre avis';
                  $powerNeeded = true;

                  require File::build_path(array('view', 'main_view.php'));
               }else{
                  $message = '<div class="alert alert-danger">Cette avis n\'exists plus !</div>';
                  ControllerUtilisateur::profil($message);
               }
            }else{
               $message = '<div class="alert alert-danger">Vous ne pouvez pas modifier un avis que vous n\'avez pas emis !</div>';
               ControllerUtilisateur::profil($message);
            }
         }else{
         	$message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la modification de l\'avis !</div>';
            ControllerUtilisateur::profil($message);
         }
      }else{
         ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
      }
   }

   public static function edited(){
      if(ControllerUtilisateur::isConnected()){
         if(isset($_POST['idUtilisateur'], $_POST['avis'], $_POST['note'], $_POST['idChambre'])){
            if($_POST['idUtilisateur']!=null && $_POST['avis']!=null && $_POST['idChambre']!=null){
               $utilisateur = ModelUtilisateur::select($_POST['idUtilisateur']);
               $chambre = ModelChambre::select($_POST['idChambre']);
               if($utilisateur!=false){
                  if($_POST['idUtilisateur']==$_SESSION['idUser']){
                     if($chambre!=false){
                        if(is_numeric($_POST['note']) && $_POST['note']>=0 && $_POST['note']<=5){
                           $utilisateur = ModelUtilisateur::select($_POST['idUtilisateur']);
                           $chambre = ModelChambre::select($_POST['idChambre']);

                           $avis = htmlspecialchars($_POST['avis']);
                           $idUtilisateur = $utilisateur->get('idUtilisateur');
                           $idChambre = $chambre->get('idChambre');
                           $note = htmlspecialchars($_POST['note']);

                           $lavis = array(
                              'idChambre' => $idChambre,
                              'idUtilisateur' => $idUtilisateur,
                              'note' => $note,
                              'commentaire' => $avis
                           );

                           $update = ModelAvis::update($lavis);

                           if($update){
                              $message = '<div class="alert alert-success">Votre avis a été modifié avec succés !</div>';
                           }else{
                              $message = '<div class="alert alert-danger">Nous n\'avons pas pu proceder a la modification de l\'avis !</div>';
                           }     
                        }else{   
                           $message = '<div class="alert alert-danger">Vous devez donner une note entre 0 et 5 (en valeur numerique) !</div>';
                        }
                     }else{
                        $message = '<div class="alert alert-danger">La chambre sur laquelle vous voulez modifier l\'avis n\'existe plus !</div>';
                     }
                  }else{
                     $message = '<div class="alert alert-danger">Vous ne pouvez pas modifier un avis que vous n\'avez pas emis !</div>';
                  }
               }else{
                  ControllerDefault::error('Vous n\'avez pas de compte chez nous pour l\'instant !');
               }
            }else{
               $message = '<div class="alert alert-danger">Vous devez renseigner touts les champs afin de modifier votre avis !</div>';
            }
         }else{
            $message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer vos infomations sur l\'avis !</div>';
         }
         ControllerUtilisateur::profil($message);
      }else{
         ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
      }
   }

   public static function delete(){
      if(ControllerUtilisateur::isConnected()){
         if(isset($_GET['idUtilisateur'], $_GET['idChambre']) && $_GET['idUtilisateur']!=null && $_GET['idChambre']!=null ){
            $idUtilisateur = htmlspecialchars($_GET['idUtilisateur']);
            if($idUtilisateur=$_SESSION['idUser']){
               $idChambre = htmlspecialchars($_GET['idChambre']);
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
               $message = '<div class="alert alert-danger">Vous ne pouvez pas supprimmer un avis que vous n\'avez pas emis !</div>';
            }
         }else{
            $message = '<div class="alert alert-danger">Nous n\'avons pas pu recuperer les information necessaire a la suppression de l\'avis !</div>';
         }
         ControllerUtilisateur::profil($message);
      }else{
         ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
      }
   }

}
?>