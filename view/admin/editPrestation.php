<?php if(!$powerNeeded) { exit(); } ?> 

<?php
// variables
$id = htmlspecialchars($prestation->get("idPrestation"));  
$nom = htmlspecialchars($prestation->get("nomPrestation"));  
$prix = htmlspecialchars($prestation->get("prix")); 
?>

<h1 class="page-header">Modification de la prestation : <?=$nom?></h1>

<form class="form-horizontal" method="post" action="index.php?controller=adminPrestations&action=editedPrestation">
	<div class="form-group">
		<label for="id_nom" class="col-sm-2 control-label">Nom de la prestation :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" value="<?=$nom?>" name="nomPrestation" id="id_nom">
		</div>
	</div>

	<div class="form-group">
		<label for="id_prix" class="col-sm-2 control-label">Prix :</label>
		<div class="col-sm-10">
			<input type="number" class="form-control" value="<?=$prix?>" name="prix" id="id_prix">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" class="btn btn-success" value="Ajouter">
			<input type="hidden" value="<?=$id?>" name="idPrestation">
			<a href="index.php?controller=adminPrestations&action=prestations" class="btn btn-danger">Annuler</a>
		</div>
	</div>
</form>