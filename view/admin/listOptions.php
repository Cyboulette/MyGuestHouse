<?php if(!$powerNeeded) { exit(); } ?>

<h1 class="page-header">Options du site</h1>
<?php 
	if(isset($message)) { echo $message; }
	if(empty($tab_options) || count($tab_options) != 4) {
		echo '<div class="alert alert-danger">Le site ne dispose d\'aucune option à configurer pour le moment !</div>';
	} else {
		$nom_site = '';
		$display_news = '';
		$theme = '';
		$main_color = '';

		$selectNomSite = ModelOption::selectCustom('nameOption', 'nom_site');
		$selectDisplayNews = ModelOption::selectCustom('nameOption', 'display_news');
		$selectThemeSite = ModelOption::selectCustom('nameOption', 'theme');
		$selectMainColor = ModelOption::selectCustom('nameOption', 'main_color_site');

		if($selectNomSite != false) {
			$nom_site = strip_tags($selectNomSite[0]->get('valueOption'));
		}
		if($selectDisplayNews != false) {
			$display_news = strip_tags($selectDisplayNews[0]->get('valueOption'));
			if($display_news == NULL) {
				$display_news = 'false';
			}
		}
		if($selectThemeSite != false) {
			$theme = strip_tags($selectThemeSite[0]->get('valueOption'));
		}
		if($selectMainColor != false) {
			$mainColor = strip_tags($selectMainColor[0]->get('valueOption'));
		}
		function checked_arg($arg, $arg2) {
			if($arg == $arg2) {
				echo 'checked';
			}
		}
?>
	<form method="post" action="index.php?controller=admin&action=updateOptions" class="form" role="form">
		<div class="form-group">
			<label for="name_site">Nom du site :</label>
			<input type="text" id="name_site" name="name_site" class="form-control" value="<?=$nom_site?>" placeholder="Indiquez le nom de votre site" />
		</div>

		<div class="form-group">
			<label for="display_news">Afficher les news sur la page d'accueil :</label>
				<div class="radio">
				<label>
					<input type="radio" name="display_news" id="display_news1" value="true" <?=checked_arg('true', $display_news)?>>
					Oui
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="display_news" id="display_news2" value="false" <?=checked_arg('false', $display_news)?>>
					Non
				</label>
			</div>
		</div>

		<div class="form-group">
			<label for="theme">Thème du site :</label>
			<div class="alert alert-info">
				Vous pouvez gérer le thème du site depuis le menu <a href="index.php?controller=admin&action=themes">"Thèmes"</a> de l'administration
			</div>
		</div>

		<div class="form-group">
			<label for="theme">Couleur principale du site :</label>
			<div id="cpMainColor" class="input-group colorpicker-component">
				<span class="input-group-addon"><i></i></span>
			    <input type="text" value="<?=$mainColor?>" name="mainColor" class="form-control" />
			</div>
		</div>

		<button type="submit" class="btn btn-primary">Enregistrer</button>
	</form>
<?php } ?>