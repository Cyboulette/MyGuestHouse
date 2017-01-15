<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des prestations</h1>

<?php
if(isset($message)) { echo $message; }
?>


<?php
if(empty($tab_allPrestation)) {
	echo '<div class="alert alert-danger">Vous ne disposez d\'aucune prestation pour le moment</div>';
	echo '<a href="index.php?controller=adminPrestations&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a>';
} else {
	echo '<a href="index.php?controller=adminPrestations&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a><br/><br/>';

	echo '<div class="table-responsive"><table class="table table-hover">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nom de la prestation</th>';
	echo '<th>Prix</th>';
	echo '<th>Actions</th>';
	echo '</tr>';
	echo '</thead>';
	foreach ($tab_allPrestation as $prestation) {
		$id = htmlspecialchars($prestation->get('idPrestation'));
		$nom = htmlspecialchars($prestation->get('nomPrestation'));
		$prix = htmlspecialchars($prestation->get('prix'));

		echo '<tr>';
		echo '<td>'.$nom.'</td>';
		echo '<td>'.$prix.' €</td>';
		echo '<td>
					<a href="index.php?controller=adminPrestations&action=editPrestation&idPrestation='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

					<button type="button" class="btn btn-xs btn-danger btnDelete" data-url="adminPrestations" data-id="'.$id.'"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>

					</td>';
		echo '</tr>';
	}

	echo '</table></div>';
	?>
	<div id="deleteItem" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Confirmation de suppression</h4>
				</div>
				<div class="modal-body"></div>
			</div>
		</div>
	</div>
	<?php
}
?>
