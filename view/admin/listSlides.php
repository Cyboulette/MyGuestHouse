<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des images défilantes</h1>
<?php if(isset($message)) echo $message; ?>

<div class="alert alert-info">Les images défilantes sont présentes sur le "carousel" en page d'accueil de votre site</div>

<?php 
	if(empty($tab_slides)) {
		echo '<div class="alert alert-danger">Il n\'y a pour le moment aucune image</div>';
		echo '<a href="index.php?controller=admin&action=manageSlides&type=add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une image</a>';
	} else {
		echo '<a href="index.php?controller=admin&action=manageSlides&type=add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une image</a> <br/><br/>';
		echo '<div class="table-responsive"><table class="table table-bordered">';
			echo '<thead>';
				echo '<tr>';
				echo '<th>ID</th>';
				echo '<th>Lien vers l\'image</th>';
				echo '<th>Actions</th>';
				echo '</tr>';
			echo '</thead>';
		foreach ($tab_slides as $slide) {
			$id = $slide->get('idSlide');
			$url = $slide->get('urlSlide');

			echo '<tr>';
				echo '<td>'.$id.'</td>';
				echo '<td><a href="'.$url.'" target="_blank">'.$url.'</a></td>';
				echo '<td>
					<a href="index.php?controller=admin&action=manageSlides&type=edit&idSlide='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>
					<button type="button" class="btn btn-xs btn-danger btnDeleteSlide" data-id="'.$id.'"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>
					<a target="_blank" href="index.php" class="btn btn-xs btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> Voir en ligne</a>
					</td>';
			echo '</tr>';
		}

		echo '</table></div>';
		?>
		<div id="deleteSlide" class="modal fade" role="dialog">
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