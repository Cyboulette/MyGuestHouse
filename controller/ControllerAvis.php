<?php

class ControllerUtilisateur{

	protected static $object = 'utilisateur';

   public static function readAll() {
      $tab_v = ModelChambre::selectAll();
      $view = 'displayAllChambre';
      $pagetitle = 'Nos Chambres';
      $powerNeeded = true;
      require_once File::build_path(array("view","main_view.php"));
   }
}
?>