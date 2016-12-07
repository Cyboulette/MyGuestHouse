<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des prestations</h1>
<?php 
	if(empty($tab_allPrestation)) {
		echo '<div class="alert alert-danger">Vous ne disposez d\'aucune prestation pour le moment</div>';
		echo '<a href="index.php?controller=admin&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a>';
	} else {
		echo '<a href="index.php?controller=admin&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a><br/><br/>';
		
		echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
				echo '<tr>';
				echo '<th>possede</th>';
				echo '<th>Nom de la prestation</th>';
				echo '<th>Prix</th>';
				echo '</tr>';
			echo '</thead>';
		foreach ($tab_allPrestation as $prestation) { 
			$id = $prestation->get('idPrestation'); 
			$nom = $prestation->get('nomPrestation'); 
			$prix = $prestation->get('prix'); 
			$checked = in_array ( $prestation , $tab_prestation); 
		 
		if($checked){ 
			$checked = 'oui'; 
		}else{ 
			$checked = 'non'; 
		}
			
			echo '<tr>';
				echo '<td>'.$checked.'</td>';
				echo '<td>'.$nom.'</td>';
				echo '<td>'.$prix.' €</td>';
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
