<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des détails</h1>

<?php  
	if(isset($message)) { echo $message; }
?>


<?php 
	if(empty($tab_allDetails)) {
		echo '<div class="alert alert-danger">Vous ne disposez d\'aucune prestation pour le moment</div>';
		echo '<a href="index.php?controller=admin&action=addDetail" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a>';
	} else {
		echo '<a href="index.php?controller=admin&action=addDetail" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un détail</a><br/><br/>';
		
		echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
				echo '<tr>';
				echo '<th>Nom de la prestation</th>';
				echo '<th>Actions</th>';
				echo '</tr>';
			echo '</thead>';
		foreach ($tab_allDetails as $detail) {
			$id = $detail->get('idDetail');
			$nom = $detail->get('nomDetail');
			
			echo '<tr>';
				echo '<td>'.$nom.'</td>';
				echo '<td>
					<a href="index.php?controller=admin&action=editDetail&idDetail='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

					<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteDetail" onclick="GETurl(id, '.$id.')"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>

					</td>';
				echo '</tr>';
		}

		echo '</table></div>';

		/* BOOTSTRAP MODAL */
		echo '<div id="deletePrestation" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Confirmation</h4>
					</div>

					<div class="modal-body">
						<p>Etes-vous certain de vouloir supprimer cette prestation ?</p>
					</div>

					<div class="modal-footer">
					<a href="index.php?controller=admin&action=deletePrestation&idPrestation='.$id.'" class="btn btn-danger">Supprimer</a	>
					</div>
					</div>

				</div>
			</div>';
	}
?>
