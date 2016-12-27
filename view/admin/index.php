<?php if(!$powerNeeded) { exit(); } ?>
<?php
  $nbUtilisateur = ModelUtilisateur::count();
  $nbChambre = ModelChambre::count();
  $nbPrestation = ModelPrestation::count();
  $nbDetails = ModelDetail::count();
  $nbReservations = ModelReservation::count();
  $nbSlides = ModelSlides::count();
  $nbNews = ModelNews::count();
?>

<h1 class="page-header">Résumé usuel</h1>

<div class="row placeholders">
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminUtilisateur&action=utilisateurs">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-users fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Utilisateurs</h4>
      <span class="text-muted"><?php if($nbUtilisateur!=null){echo$nbUtilisateur;}else{echo"0";}?> utilisateur<?php if($nbUtilisateur>1)echo"s";?> inscrit<?php if($nbUtilisateur>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminChambres&action=chambres">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-bed fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Chambres</h4>
      <span class="text-muted"><?php if($nbChambre!=null){echo$nbChambre;}else{echo"0";}?> chambre<?php if($nbChambre>1)echo"s";?> enregistrée<?php if($nbChambre>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminPrestations&action=prestations">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-glass fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Prestations</h4>
      <span class="text-muted"><?php if($nbPrestation!=null){echo$nbPrestation;}else{echo"0";}?> prestation<?php if($nbPrestation>1)echo"s";?> enregistrée<?php if($nbPrestation>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminDetails&action=details">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-plug fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Détails</h4>
      <span class="text-muted"><?php if($nbDetails!=null){echo$nbDetails;}else{echo"0";}?> détail<?php if($nbDetails>1)echo"s";?> enregistrée<?php if($nbDetails>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminReservations&action=reservations">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-calendar fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Réservations</h4>
      <span class="text-muted"><?php if($nbReservations!=null){echo$nbReservations;}else{echo"0";}?> reservation<?php if($nbReservations>1)echo"s";?> enregistrée<?php if($nbReservations>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminSlides&action=slides">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa fa-hand-rock-o fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Images défilantes</h4>
      <span class="text-muted"><?php if($nbSlides!=null){echo$nbSlides;}else{echo"0";}?> image<?php if($nbSlides>1)echo"s";?> défilante<?php if($nbSlides>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminNews&action=news">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa fa-newspaper-o fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Actualités</h4>
      <span class="text-muted"><?php if($nbNews!=null){echo$nbNews;}else{echo"0";}?> actualité<?php if($nbNews>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminOptions&action=list">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-cogs fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Options</h4>
      <span class="text-muted">Gérer les options du site</span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminThemes&action=themes">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-paint-brush fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Thèmes</h4>
      <span class="text-muted">Gérer les thèmes du site</span>
    </a>
  </div>
</div>