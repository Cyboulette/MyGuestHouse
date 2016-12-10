<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des actualités de votre site</h1>
<?php if(isset($message)) echo $message; ?>

<?php 
	if(empty($tab_news)) {
		echo '<div class="alert alert-danger">Vous ne disposez d\'aucune actualité pour le moment</div>';
		echo '<a href="index.php?controller=admin&action=manageNews&type=add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une actualité</a>';
	} else {
		if (ModelChambre::count()<5) {
			echo '<a href="index.php?controller=admin&action=manageNews&type=add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une actualité</a> <br/><br/>';
		}
		echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
				echo '<tr>';
				echo '<th>ID</th>';
				echo '<th>Titre de l\'actualité</th>';
				echo '<th>Date</th>';
				echo '<th>Etat</th>';
				echo '<th>Actions</th>';
				echo '</tr>';
			echo '</thead>';
		foreach ($tab_news as $news) {
			$id = $news->get('idNews');
			$titre = $news->get('titreNews');
			$date = $news->get('dateNews');
			$publie = $news->get('publie');
			$displayEtat = ($publie != 1 ? '<span class="label label-warning">Non publié</span>':'<span class="label label-success">Publié</span>');

			echo '<tr>';
				echo '<td>'.$id.'</td>';
				echo '<td>'.$titre.'</td>';
				echo '<td>'.$date.'</td>';
				echo '<td>'.$displayEtat.'</td>';
				echo '<td>
					<a href="index.php?controller=admin&action=manageNews&type=edit&idNews='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>
					<button type="button" class="btn btn-xs btn-danger btnDeleteNews" data-id="'.$id.'">Supprimer</button>
					</td>';
			echo '</tr>';
		}

		echo '</table></div>';
		?>
		<div id="deleteNews" class="modal fade" role="dialog">
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