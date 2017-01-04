<?php if(!$powerNeeded) { exit(); } ?>

<h1 class="page-header">Ajouter une chambre</h1>

<form class="form-horizontal" method="post" action="index.php?controller=adminChambres&action=addedChambre">
  <div class="form-group">
    <label for="id_nom" class="col-sm-2 control-label">Nom de la chambre à ajouter :</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="EX : La voile bleue" name="nom" id="id_nom">
    </div>
  </div>

  <div class="form-group">
    <label for="id_prix" class="col-sm-2 control-label">Prix<small>/nuit</small> :</label>
    <div class="col-sm-10">
      <input type="number" min="0" class="form-control" placeholder="EX : 50" name="prix" id="id_prix">
    </div>
  </div>

  <div class="form-group">
    <label for="id_superficie" class="col-sm-2 control-label">Superficie :</label>
    <div class="col-sm-10">
      <input type="number" min="0" class="form-control" placeholder="EX : 25" name="superficie" id="id_superficie">
    </div>
  </div>

  <div class="form-group">
    <label for="desc_chambre" class="col-sm-2 control-label">Description :</label>
    <div class="col-sm-10">
      <textarea id="desc_chambre" name="description" class="form-control" placeholder="Description de la chambre"></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-success" value="Ajouter">
      <a href="index.php?controller=adminChambres&action=chambres" class="btn btn-danger">Annuler</a>
    </div>
  </div>
</form>