<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des détails</h1>
<?php 
	if(empty($tab_allDetails)) {
		echo '<div class="alert alert-danger">Vous ne disposez d\'aucun détail pour le moment</div>';
		echo '<a href="index.php?controller=adminDetails&action=addDetail" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un détail</a>';
	} else {
		echo '<a href="index.php?controller=adminDetails&action=addDetail" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un détail</a><br/><br/>';
		

		echo '<form action="index.php?controller=adminDetails&action=managedDetail" method="POST">';
		echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
				echo '<tr>';
				echo '<th>Nom du detail</th>';
				echo '<th>Valeur</th>';
				echo '</tr>';
			echo '</thead>';
		foreach ($tab_allDetails as $detail) { 
			$id = $detail->get('idDetail');
			$nom = $detail->get('nomDetail');
			$checked = in_array ( $detail , $tab_detail);
			$valeur = ModelDetail::selectValeur($idChambre, $id);

			echo '<tr>';
				echo '<td><label for="detail'.$id.'">'.$nom.'</label></td>';
				echo '<td>';
					echo '<input id="detail'.$id.'" type="text"'; 
						if($valeur!=false){
							echo 'value='.$valeur;
						}else{
							echo "placeholder='OUI/NON/1/10/...'";
						}
					echo '>'; 
				echo '</td>';
			echo '</tr>';
		}

		echo '</table></div>';
		echo '<div class="col-xs-6 col-sm-5 col-md-2">';
			echo '<input type="submit" class="btn btn-s btn-success btn-block" value="Valider">';
		echo "</div>";
        echo '<input type="hidden" name="idChambre" value="'.$idChambre.'"/>';
		echo '</form>';
	}
?>


