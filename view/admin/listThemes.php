<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des thèmes de votre site</h1>

<?php 
	$nbTemplates = count($folders);
	if($nbTemplates > 2) {
		foreach ($folders as $folder) {
			if($folder != '.' && $folder != '..') {
				$filePath = File::build_path(array("view", "themes", $folder, "template.json"));
				if(file_exists($filePath)) {
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
						echo '<br/><br/><div class="alert alert-info">Ce thème est le thème d\'administration, il est automatiquement sélectionné</div>';
					}
					if(Conf::$theme == $json_data->template_name) {
						echo '<br/><br/><div class="alert alert-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Thème sélectionné</div>';
					} else if($json_data->type == "site") {
						echo '<br/><br/><button class="btn btn-success">Sélectionner</button>';
					}
					echo '</div>';
				}
			}
		}
	} else {
		echo '<div class="alert alert-danger">Aucun thème n\'est disponible pour votre site !</div>';
	}
?>

<style>
	.theme {
		margin: 10px;
		padding: 15px;
		border: 1px solid black;
		border-radius: 3px;
	}

	.theme-admin {
		background-color: #222;
		color: white;
	}

	.theme h1 {
		margin-top: 0px;
	}
</style>