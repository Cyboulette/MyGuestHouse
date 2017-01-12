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
    <a href="?controller=adminUtilisateurs&action=utilisateurs">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-users fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Utilisateurs</h4>
      <span class="text-muted"><?php echo$nbUtilisateur; ?> utilisateur<?php if($nbUtilisateur>1)echo"s";?> inscrit<?php if($nbUtilisateur>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminChambres&action=chambres">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-bed fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Chambres</h4>
      <span class="text-muted"><?php echo$nbChambre; ?> chambre<?php if($nbChambre>1)echo"s";?> enregistrée<?php if($nbChambre>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminPrestations&action=prestations">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-glass fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Prestations</h4>
      <span class="text-muted"><?php echo$nbPrestation; ?> prestation<?php if($nbPrestation>1)echo"s";?> enregistrée<?php if($nbPrestation>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminDetails&action=details">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-plug fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Détails</h4>
      <span class="text-muted"><?php echo$nbDetails; ?> détail<?php if($nbDetails>1)echo"s";?> enregistrée<?php if($nbDetails>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminReservations&action=reservations">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-calendar fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Réservations</h4>
      <span class="text-muted"><?php echo$nbReservations; ?> reservation<?php if($nbReservations>1)echo"s";?> enregistrée<?php if($nbReservations>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminSlides&action=slides">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa fa-hand-rock-o fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Images défilantes</h4>
      <span class="text-muted"><?php echo$nbSlides; ?> image<?php if($nbSlides>1)echo"s";?> défilante<?php if($nbSlides>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminNews&action=news">
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa fa-newspaper-o fa-inverse fa-stack-1x"></i>
      </span>
      <h4>Actualités</h4>
      <span class="text-muted"><?php echo$nbNews; ?> actualité<?php if($nbNews>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=adminOptions&action=liste">
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