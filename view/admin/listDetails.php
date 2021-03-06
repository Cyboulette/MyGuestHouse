<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des détails</h1>

<?php
if(isset($message)) { echo $message; }
?>


<?php
if(empty($tab_allDetails)) {
	echo '<div class="alert alert-danger">Vous ne disposez d\'aucun détail pour le moment</div>';
	echo '<a href="index.php?controller=adminDetails&action=addDetail" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un détail</a>';
} else {
	echo '<a href="index.php?controller=adminDetails&action=addDetail" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un détail</a><br/><br/>';

	echo '<div class="table-responsive"><table class="table table-hover">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nom du détail</th>';
	echo '<th>Actions</th>';
	echo '</tr>';
	echo '</thead>';
	foreach ($tab_allDetails as $detail) {
		$id = htmlspecialchars($detail->get('idDetail'));
		$nom = htmlspecialchars($detail->get('nomDetail'));

		echo '<tr>';
		echo '<td>'.$nom.'</td>';
		echo '<td>
					<a href="index.php?controller=adminDetails&action=editDetail&idDetail='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

					<button type="button" class="btn btn-xs btn-danger btnDelete" data-url="adminDetails" data-id="'.$id.'"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>

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
