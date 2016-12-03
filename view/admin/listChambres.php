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
				echo '<td><a href="index.php?controller=admin&action=manageDetails&idChambre='.$id.'" class="btn btn-xs btn-primary">'.$nbDetails.' <i class="fa fa-cog" aria-hidden="true"></i></a></td>';
				echo '<td>
					<a href="index.php?controller=admin&action=editChambre&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>
					<a href="index.php?controller=admin&action=deleteChambre&idChambre='.$id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Supprimer</a>
				</td>';
			echo '</tr>';
		}
		echo '</table></div>';
	}
?>