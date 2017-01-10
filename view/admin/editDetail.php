<?php if(!$powerNeeded) { exit(); } ?> 

<?php
	// variables
	$id = htmlspecialchars($detail->get("idDetail"));  
	$nom = htmlspecialchars($detail->get("nomDetail")); 
?>

<h1 class="page-header">Modification du détail : <?=$nom?></h1>

<form class="form-horizontal" method="post" action="index.php?controller=adminDetails&action=editedDetail">
	<div class="form-group">
		<label for="id_nom" class="col-sm-2 control-label">Nom du détail :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" value="<?=$nom?>" name="nomDetail" id="id_nom">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" class="btn btn-success" value="Modifier">
			<input type="hidden" value="<?=$id?>" name="idDetail">
			<a href="index.php?controller=adminDetails&action=details" class="btn btn-danger">Annuler</a>
		</div>
	</div>
</form>