<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des chambres</h1>

<?php  
	if(isset($message)) { echo $message; }
?>

<?php 
	if(empty($tab_chambres)) {
		echo '<div class="alert alert-danger">Vous ne disposez d\'aucune chambre pour le moment</div>';
		echo '<a href="index.php?controller=adminChambres&action=addChambre" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une chambre</a>';
	} else {
		if (ModelChambre::count()<5) {
			echo '<a href="index.php?controller=adminChambres&action=addChambre" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une chambre</a> <br/><br/>';
		}
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
			// $nbPrestations = count(ModelChambre::selectPrestation($id));
			// $nbDetails = count(ModelChambre::selectDetail($id));
			$nbPrestations = count(ModelPrestation::selectAllByChambre($id));
			$nbDetails = count(ModelChambre::selectDetail($id));
			echo '<tr>';
				echo '<td>'.$id.'</td>';
				echo '<td>'.$nom.'</td>';
				echo '<td>'.$prix.' €</td>';
				echo '<td>'.$superficie.' m²</td>';
				echo '<td><a href="index.php?controller=adminPrestations&action=managePrestations&idChambre='.$id.'" class="btn btn-xs btn-primary">'.$nbPrestations.' <i class="fa fa-cog" aria-hidden="true"></i></a></td>';
				echo '<td><a href="index.php?controller=adminDetails&action=manageDetails&idChambre='.$id.'" class="btn btn-xs btn-primary">'.$nbDetails.' <i class="fa fa-cog" aria-hidden="true"></i></a></td>';
				echo '<td>
					<a href="index.php?controller=adminChambres&action=editChambre&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

					<button type="button" class="btn btn-xs btn-danger btnDeleteReservation" data-toggle="modal" data-target="#deleteChambre"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>

					</td>';
			echo '</tr>';
		}

		echo '</table></div>';

		/* BOOTSTRAP MODAL */
		?>
		 <div id="deleteReservation" class="modal fade" role="dialog">
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
