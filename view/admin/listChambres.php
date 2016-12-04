<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des chambres</h1>
<?php 
	if(empty($tab_chambres)) {
		echo '<div class="alert alert-danger">Vous ne disposez d\'aucune chambre pour le moment</div>';
		echo '<a href="index.php?controller=admin&action=addChambre" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une chambre</a>';
	} else {
		echo '<a href="index.php?controller=admin&action=addChambre" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une chambre</a> <br/><br/>';
		echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
				echo '<tr>';
				echo '<th>ID</th>';
				echo '<th>Nom de la chambre</th>';
				echo '<th>Prix</th>';
				echo '<th>Superficie</th>';
				echo '<th>Prestations</th>';
				echo '<th>Détails</th>';
				echo '<th>Actions</th>';
				echo '</tr>';
			echo '</thead>';
		foreach ($tab_chambres as $chambre) {
			$id = $chambre->get('idChambre');
			$nom = $chambre->get('nomChambre');
			$prix = $chambre->get('prixChambre');
			$superficie = $chambre->get('superficieChambre');
			$nbPrestations = count(ModelChambre::selectPrestation($id));
            $nbDetails = count(ModelChambre::selectDetail($id));
			echo '<tr>';
				echo '<td>'.$id.'</td>';
				echo '<td>'.$nom.'</td>';
				echo '<td>'.$prix.' €</td>';
				echo '<td>'.$superficie.' m²</td>';
				echo '<td><a href="index.php?controller=admin&action=managePrestations&idChambre='.$id.'" class="btn btn-xs btn-primary">'.$nbPrestations.' <i class="fa fa-cog" aria-hidden="true"></i></a></td>';
				echo '<td><button class="btn btn-xs btn-primary">'.$nbDetails.' <i class="fa fa-cog" aria-hidden="true"></i></button></td>';
				echo '<td>
					<a href="index.php?controller=admin&action=editChambre&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

					<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteChambre" value="'.$id.'">Supprimer</button>

					</td>';
			echo '</tr>';



		}

		echo '</table></div>';

		/* BOOTSTRAP MODAL */
		echo '<div id="deleteChambre" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Confirmation</h4>
					</div>

					<div class="modal-body">
						<p>Etes-vous certain de vouloir supprimer cette chambre ?</p>
					</div>

					<div class="modal-footer">
					<a href="index.php?controller=admin&action=deleteChambre&idChambre='.$id.'" class="btn btn-xs btn-danger">Supprimer</a	>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					</div>

				</div>
			</div>';
	}
?>