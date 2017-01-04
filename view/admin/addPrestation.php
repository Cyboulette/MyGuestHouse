<?php if(!$powerNeeded) { exit(); } ?>

<h1 class="page-header">Ajout d'une prestation</h1>

<form class="form-horizontal" method="post" action="index.php?controller=adminPrestations&action=addedPrestation">
	<div class="form-group">
		<label for="id_nom" class="col-sm-2 control-label">Nom de la prestation à ajouter :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="EX : Repassage" name="nomPrestation" id="id_nom">
		</div>
	</div>

	<div class="form-group">
		<label for="id_prix" class="col-sm-2 control-label">Prix :</label>
		<div class="col-sm-10">
			<input type="number" class="form-control" placeholder="EX : 15" name="prix" id="id_prix">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" class="btn btn-success" value="Ajouter">
			<a href="index.php?controller=adminPrestations&action=prestations" class="btn btn-danger">Annuler</a>
		</div>
	</div>
</form>