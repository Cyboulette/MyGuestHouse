<?php if(!$powerNeeded) { exit(); } ?> 

<?php
	// variables
	$id = $detail->get("idDetail");  
	$nom = $detail->get("nomDetail"); 
?>

<?php
	echo "<h1 class='page-header'>{$nom}</h1>";
	echo "
		<form method='post' action='index.php?controller=admin&action=editedDetail' enctype='multipart/form-data'>

			<div class='form-group row'>
				<label for='id_nom' class='col-xs-3 col-form-label'>Nom du détail : </label>
				<div class='col-xs-3'>
					<input type='text' value='{$nom}' name='nomDetail' id='id_nom'>
				</div>
			</div>

			<div class='col-xs-6 col-sm-5 col-md-2'>
				<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
				<input type='hidden' value='{$id}' name='idDetail'/>
			</div>
		</form>

		<div class='col-xs-6 col-sm-5 col-md-2'>
			<a href='?controller=admin&action=details' class='btn btn-s btn-danger btn-block'>Annuler</a>
		</div>
	";  
?>