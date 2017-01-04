<?php if(!$powerNeeded) { exit(); } ?>

<?php   
  // variables 
  $nom = htmlspecialchars($chambre->get("nomChambre")); 
  $prix = htmlspecialchars($chambre->get("prixChambre")); 
  $superficie = htmlspecialchars($chambre->get("superficieChambre")); 
  $description = htmlspecialchars($chambre->get("descriptionChambre"));
  $id = htmlspecialchars($chambre->get("idChambre")); 
?> 

<h1 class="page-header">Modification de la chambre : <?=$nom?></h1>

<form class="form-horizontal" method="post" action="index.php?controller=adminChambres&action=editedChambre">
  <div class="form-group">
    <label for="id_nom" class="col-sm-2 control-label">Nom de la chambre :</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="<?=$nom?>" name="nom" id="id_nom">
    </div>
  </div>

  <div class="form-group">
    <label for="id_prix" class="col-sm-2 control-label">Prix<small>/nuit</small> :</label>
    <div class="col-sm-10">
      <input type="number" min="0" class="form-control" value="<?=$prix?>" name="prix" id="id_prix">
    </div>
  </div>

  <div class="form-group">
    <label for="id_superficie" class="col-sm-2 control-label">Superficie :</label>
    <div class="col-sm-10">
      <input type="number" min="0" class="form-control" value="<?=$superficie?>" name="superficie" id="id_superficie">
    </div>
  </div>

  <div class="form-group">
    <label for="desc_chambre" class="col-sm-2 control-label">Description :</label>
    <div class="col-sm-10">
      <textarea id="desc_chambre" name="description" class="form-control"><?=$description?></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-success" value="Ajouter">
      <input type="hidden" name="id" value="<?=$id?>">
      <a href="index.php?controller=adminChambres&action=chambres" class="btn btn-danger">Annuler</a>
    </div>
  </div>
</form>

