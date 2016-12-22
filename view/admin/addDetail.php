<?php if(!$powerNeeded) { exit(); } ?>


<?php  

	echo "<h1 class='page-header'>Ajout d'un détail</h1>";
	echo "
		<form method='post' action='index.php?controller=admin&action=addedDetail' enctype='multipart/form-data'>

			<div class='form-group row'>
				<label for='id_nom' class='col-xs-3 col-form-label'>Nom du detail : </label>
				<div class='col-xs-3'>
					<input type='text' placeholder='EX : Repassage' name='nomDetail' id='id_nom'>
				</div>
			</div>

			<div class='col-xs-6 col-sm-5 col-md-2'>
				<input type='submit' class='btn btn-s btn-success btn-block' value='Ajouter'>
			</div>
		</form>

		<div class='col-xs-6 col-sm-5 col-md-2'>
			<a href='?controller=admin&action=details' class='btn btn-s btn-danger btn-block'>Annuler</a>
		</div>
	"; 

?>