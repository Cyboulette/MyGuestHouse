<?php if(!$powerNeeded) { exit(); } ?> 

<?php
// variables
$id = $prestation->get("idPrestation");  
$nom = $prestation->get("nomPrestation");  
$prix = $prestation->get("prix"); 
?>

<?php
echo "<h1 class='page-header'>{$nom}</h1>";
echo "
	<form method='post' action='index.php?controller=adminPrestations&action=editedPrestation' enctype='multipart/form-data'>

		<div class='form-group row'>
			<label for='id_nom' class='col-xs-3 col-form-label'>Nom de la prestation : </label>
			<div class='col-xs-3'>
				<input type='text' value='{$nom}' name='nomPrestation' id='id_nom'>
			</div>
		</div>

		<div class='form-group row'>
			<label for='id_prix' class='col-xs-3 col-form-label'>Prix : </label>
			<div class='col-xs-3'>
				<input type='number' min='0' value='{$prix}' name='prix' id='id_prix'>&euro;
			</div>
		</div>

		<div class='col-xs-6 col-sm-5 col-md-2'>
			<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
			<input type='hidden' value='{$id}' name='idPrestation'/>
		</div>

	</form>

	<div class='col-xs-6 col-sm-5 col-md-2'>
		<a href='?controller=adminPrestations&action=prestations' class='btn btn-s btn-danger btn-block'>Annuler</a>
	</div>
";  
?>