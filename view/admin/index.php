<?php if(!$powerNeeded) { exit(); } ?>
<?php
  $nbChambre = count(ModelChambre::selectAll());
  $nbUtilisateur = count(ModelUtilisateur::selectAll());
?>

<h1 class="page-header">Résumé usuel</h1>

<div class="row placeholders">
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Utilisateurs</h4>
    <span class="text-muted"><?php if($nbUtilisateur!=null){echo$nbUtilisateur;}else{echo"0";}?> utilisateur<?php if($nbUtilisateur>1)echo"s";?> inscrit<?php if($nbUtilisateur>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Chambres</h4>
    <span class="text-muted"><?php if($nbChambre!=null){echo$nbChambre;}else{echo"0";}?> chambre<?php if($nbChambre>1)echo"s";?> enregistrée<?php if($nbChambre>1)echo"s";?></span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Réservations</h4>
    <span class="text-muted">XX Réservations</span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
    <h4>Label</h4>
    <span class="text-muted">Something else</span>
  </div>
</div>