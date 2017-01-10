<?php

class ControllerAvis{

	protected static $object = 'avis';

   public static function edit(){
      if(ControllerUtilisateur::isConnected()){
         if(isset($_GET['$idUtilisateur'], $_GET['$idChambre']) && $_GET['$idUtilisateur']!=null && $_GET['$idChambre']!=null) {
         	$idUtilisateur = htmlspecialchars($_GET['$idUtilisateur']);
            if($idUtilisateur=$_SESSION['idUser']){
            	$idChambre = htmlspecialchars($_GET['$idChambre']);
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

   // public static function edit(){
   //    if(ControllerUtilisateur::isConnected()){
   //       if(isset($_GET['$idUtilisateur'], $_GET['$idChambre']) && $_GET['$idUtilisateur']!=null && $_GET['$idChambre']!=null) {
   //          $idUtilisateur = htmlspecialchars($_GET['$idUtilisateur']);
   //          $idChambre = htmlspecialchars($_GET['$idChambre']);
   //          $avis = ModelAvis::select($idUtilisateur, $idChambre);
   //          if(){

   //          }
   //       }else{
   //          $message = '<div class="alert alert-danger">nous n\'avons pas pu recuperer les information necessaire a la modification de l\'avis !</div>';
   //          ControllerUtilisateur::profil($message);
   //       }
   //    }else{
   //       ControllerDefault::error('Vous devez être connecter pour effectuer cette action !');
   //    }
   // }

}
?>