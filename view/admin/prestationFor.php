<?php
/**
 * This view provide the to add and take off prestations for reservations
 **/
if(!$powerNeeded) { exit(); } ?>
<?php
	if($_GET['controller'] == 'adminPrestations'){
		echo '<h1 class="page-header">Liste des prestations</h1>';
		if(empty($tab_allPrestation)) {
			echo '<div class="alert alert-danger">Vous ne disposez d\'aucune prestation pour le moment</div>';
			echo '<a href="index.php?controller=adminPrestations&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a>';
		} else {
			echo '<a href="index.php?controller=adminPrestations&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation</a><br/><br/>';

			echo '<form action="index.php?controller=adminPrestations&action=managedPrestation" method="POST">';
			echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Disponibilité</th>';
			echo '<th>Nom de la prestation</th>';
			echo '<th>Prix</th>';
			echo '</tr>';
			echo '</thead>';
			foreach ($tab_allPrestation as $prestation) {
				$id = $prestation->get('idPrestation');
				$nom = $prestation->get('nomPrestation');
				$prix = $prestation->get('prix');
				$checked = in_array ( $prestation , $tab_prestation);

				// if($checked){
				// 	$checked = 'oui';
				// }else{
				// 	$checked = 'non';
				// }

				echo '<tr>';
				echo '<td><input type="checkbox" name="prestations[]" id="checkbox'.$id.'" value="'.$id.'"';
				if ($checked){echo 'checked';}
				echo '></td>';
				echo '<td><label for="checkbox'.$id.'">'.$nom.'</label></td>';
				echo '<td>'.$prix.' €</td>';
				echo '</tr>';
			}

			echo '</table></div>';
			echo '<div class="col-xs-6 col-sm-5 col-md-2">';
			echo '<input type="submit" class="btn btn-s btn-success btn-block" value="Valider">';
			echo "</div>";
			echo '<input type="hidden" name="idChambre" value="'.$idChambre.'"/>';
			echo '</form>';
		}
	} elseif ($_GET['controller'] == 'adminReservations'){
		echo '<h1 class="page-header">Liste des prestations de la reservation '.$_GET['idReservation'].'</h1>';
		if(empty($tab_allPrestation)) {
			echo '<div class="alert alert-danger">Vous ne disposez d\'aucune prestation pour le moment</div>';
			echo '<a href="index.php?controller=adminReservations&action=addPrestation" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une prestation </a>';
		} else {

			echo '<div class=""></div>';
			echo '<form action="index.php?controller=adminReservations&action=managedPrestationForReservation" method="POST">';
			echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Ajout</th>';
			echo '<th>Nom de la prestation</th>';
			echo '<th>Prix</th>';
			echo '</tr>';
			echo '</thead>';
			foreach ($tab_allPrestation as $prestation) {
				$id = $prestation->get('idPrestation');
				$nom = $prestation->get('nomPrestation');
				$prix = $prestation->get('prix');
				$checked = in_array ( $prestation , $tab_prestation);

				echo '<tr>';
				echo '<td><input type="checkbox" name="prestations[]" id="checkbox'.$id.'" value="'.$id.'"';
					if ($checked){echo 'checked';}
				echo '></td>';
				echo '<td><label for="checkbox'.$id.'">'.$nom.'</label></td>';
				echo '<td>'.$prix.' €</td>';
				echo '</tr>';
			}

			echo '</table></div>';
			echo '<div class="col-xs-6 col-sm-5 col-md-2">';
			echo '<input type="submit" class="btn btn-s btn-success btn-block" value="Valider">';
			echo "</div>";
			echo '<input type="hidden" name="idReservation" value="'.$idReservation.'"/>';
			echo '</form>';
		}
	}


?>

