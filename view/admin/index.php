<?php if(!$powerNeeded) { exit(); } ?>
<?php
  $nbChambre = ModelChambre::count();
  $nbUtilisateur = ModelUtilisateur::count();
  $nbPrestation = ModelPrestation::count();
  var_dump($nbPrestation);
?>

<h1 class="page-header">Résumé usuel</h1>

<div class="row placeholders">
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Utilisateurs</h4>
    <span class="text-muted"><?php if($nbUtilisateur!=null){echo$nbUtilisateur;}else{echo"0";}?> utilisateur<?php if($nbUtilisateur>1)echo"s";?> inscrit<?php if($nbUtilisateur>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=admin&action=chambres">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Chambres</h4>
      <span class="text-muted"><?php if($nbChambre!=null){echo$nbChambre;}else{echo"0";}?> chambre<?php if($nbChambre>1)echo"s";?> enregistrée<?php if($nbChambre>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=admin&action=prestations">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Prestations</h4>
      <span class="text-muted"><?php if($nbPrestation!=null){echo$nbPrestation;}else{echo"0";}?> prestation<?php if($nbPrestation>1)echo"s";?> enregistrée<?php if($nbPrestation>1)echo"s";?></span>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Réservations</h4>
    <span class="text-muted">XX Réservations</span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <a href="?controller=admin&action=options">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Options</h4>
    </a>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Label</h4>
    <span class="text-muted">Something else</span>
  </div>
</div>