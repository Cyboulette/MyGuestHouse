<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des thèmes de votre site</h1>
<?php if(isset($message)) echo $message; ?>

<?php 
	$nbTemplates = count($folders);
	if($nbTemplates > 2) {
		foreach ($folders as $folder) {
			if($folder != '.' && $folder != '..') {
				$filePath = File::build_path(array("view", "themes", $folder, "template.json"));
				if(file_exists($filePath)) {
					// NOTE : Penser à supprimer l'html des potentielles variable, sait-on jamais !
					$json_source = file_get_contents($filePath);
					$json_data = json_decode($json_source);
					if($json_data->type == "admin") {
						$classToAdd = "theme-admin";
					} else {
						$classToAdd = "theme-site";
					}
					echo '<div class="theme '.$classToAdd.'">';
						echo '<h1>Thème : '.$json_data->template_name.'</h1>';
						echo '<p>'.$json_data->template_desc.'</p>';
						echo '<em>Version : '.$json_data->template_version.' | Développé par : '.$json_data->template_author.'</em>';
					if($json_data->type == "admin") {
						echo '<div class="alert alert-info">Ce thème est le thème d\'administration, il est automatiquement sélectionné</div>';
					}
					if(Conf::$theme == $json_data->template_name) {
						echo '<div class="alert alert-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Thème sélectionné</div>';
					} else if($json_data->type == "site") {
						echo '<button class="btn btn-success btnSelectTheme" data-name="'.$json_data->template_name.'">Sélectionner</button>';
					}
					echo '</div>';
				}
			}
		}
	} else {
		echo '<div class="alert alert-danger">Aucun thème n\'est disponible pour votre site !</div>';
	}
?>
<div id="selectTheme" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirmation de changement de thème</h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>