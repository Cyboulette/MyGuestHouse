<?php if(!$powerNeeded) { exit(); } ?> 

<?php
	if(!isset($avis)){
        exit();
  }
?>

<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2"> 

  <h1 class='page-header'>Modification de l'avis</h1>
    	

  <p><h4>Modifier l'avis de <?=$prenomUtilisateur?> <?=$nomUtilisateur?> sur la chambre : <?=$nomChambre?></h4></p> 
  </br>

  <form class='col-xs-offset-1' method='post' action='?controller=Adminavis&action=edited' enctype='multipart/form-data'>

    <div class="form-group row">
      <label for="id_note" class="col-xs-2 control-label">Note :</label>
      <div class="col-xs-10">
        <input type="number" min="0" max="5" class="form-control" value=<?=$note?> name="note" id="id_note">
      </div>
    </div>

    <div class="form-group row">
      <label for="id_avis" class="col-xs-2 control-label">Avis :</label>
      <div class="col-xs-10">
        <textarea id="id_avis" name="avis" class="form-control"><?=$commentaire?></textarea>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" class="btn btn-success" value="Modifier">
        <input type="hidden" name="idUtilisateur" value=<?=$idUtilisateur?>>
        <input type="hidden" name="idChambre" value=<?=$idChambre?>>
        <input type="hidden" name="from" value=<?=$from?>>
      </div>
    </div>
  </form>
</div>