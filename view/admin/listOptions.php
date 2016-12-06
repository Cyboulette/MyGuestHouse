<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Options du site</h1>
<?php 
	if(isset($message)) { echo $message; }
	if(empty($tab_options) || count($tab_options) != 3) {
		echo '<div class="alert alert-danger">Le site ne dispose d\'aucune option à configurer pour le moment !</div>';
	} else {
		$nom_site = '';
		$display_news = '';
		$theme = '';

		$selectNomSite = ModelOption::selectCustom('nameOption', 'nom_site');
		$selectDisplayNews = ModelOption::selectCustom('nameOption', 'display_news');
		$selectThemeSite = ModelOption::selectCustom('nameOption', 'theme');
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
				<div class="radio">
				<label>
					<input type="radio" name="theme" id="theme" value="default" checked readonly="readonly">
					Par défaut
				</label>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Enregistrer</button>
	</form>
<?php } ?>