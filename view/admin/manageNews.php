<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header"><?=$titreAction?></h1>
<?php if(isset($message)) echo $message; ?>

<?php 
	if($type == "add") {
		$titreNews = (isset($_POST['titreNews']) ? htmlspecialchars($_POST['titreNews']):'');
		$contenuNews = (isset($_POST['contenuNews']) ? htmlspecialchars($_POST['contenuNews']):'');
		$dateNews = (isset($_POST['dateNews']) ? date('Y-m-d', strtotime($_POST['dateNews'])):date('Y-m-d'));
		$etatNews = (isset($_POST['etatNews']) ? $_POST['etatNews']:'0');
		$urlAction = 'index.php?controller=adminNews&action=addNews&type=add';
		$titleBouton = 'Ajouter';
	} elseif($type == "edit") {
		$idNews = $readNews->get('idNews');
		$titreNews = (isset($_POST['titreNews']) ? htmlspecialchars($_POST['titreNews']):$readNews->get('titreNews'));
		$contenuNews = (isset($_POST['contenuNews']) ? htmlspecialchars($_POST['contenuNews']):$readNews->get('contenuNews'));
		$dateNews = (isset($_POST['dateNews']) ? date('Y-m-d', strtotime($_POST['dateNews'])):$readNews->get('dateNews'));
		$etatNews = (isset($_POST['etatNews']) ? $_POST['etatNews']:$readNews->get('publie'));
		$urlAction = 'index.php?controller=adminNews&action=editNews&type=edit&idNews='.$idNews;
		$titleBouton = 'Modifier';
	}
?>

<form class="form" role="form" method="POST" action="<?=$urlAction?>">
	<div class="form-group">
		<label for="titreNews">Titre de l'actualité</label>
		<input type="text" class="form-control" id="titreNews" name="titreNews" placeholder="Indiquez le titre de l'actualité" value="<?=$titreNews?>">
	</div>

	<div class="form-group">
		<label for="contenuNews">Contenu de l'actualité</label><br/>
		<div class="btn-group" role="group" aria-label="BBCODE">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Taille de police
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				<li><a href="" onclick="insertTag('[grand]', '[/grand]', 'contenuNews'); return false;"">Grand</a></li>
				<li><a href="" onclick="insertTag('[moyen]', '[/moyen]', 'contenuNews'); return false;"">Moyen</a></li>
				<li><a href="" onclick="insertTag('[petit]', '[/petit]', 'contenuNews');return false;"">Petit</a></li>
				</ul>
			</div>
			<button type="button" class="btn btn-default" onclick="insertTag('[b]', '[/b]', 'contenuNews')">Gras</button>
			<button type="button" class="btn btn-default" onclick="insertTag('[i]', '[/i]', 'contenuNews')">Italique</button>
			<button type="button" class="btn btn-default" onclick="insertTag('[u]', '[/u]', 'contenuNews')">Souligné</button>
			<button type="button" class="btn btn-default" onclick="insertTag('', '', 'contenuNews', 'lien')">Lien</button>
			<button type="button" class="btn btn-default" onclick="insertTag('', '', 'contenuNews', 'liste')">Liste</button>
		</div><br/><br/>
		<textarea class="form-control" id="contenuNews" rows="10" name="contenuNews" placeholder="Indiquez le contenu de l'actualité"><?=$contenuNews?></textarea>
	</div>

	<div class="form-group">
		<label for="dateNews">Date de l'actualité</label>
		<input type="date" name="dateNews" id="dateNews" class="form-control" value="<?=$dateNews?>">
	</div>

	<div class="form-group">
		<label for="etatNews1">Etat de l'actualité</label>
		<div class="radio">
			<label>
				<input type="radio" name="etatNews" id="etatNews1" value="1" <?=ControllerDefault::checked(1, $etatNews);?>>
				Publiée
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="etatNews" id="etatNews2" value="0" <?=ControllerDefault::checked(0, $etatNews);?>>
				Non publiée
			</label>
		</div>
	</div>
	<?php if($type == "edit") echo '<input type="hidden" name="idNews" value="'.$idNews.'">'; ?>
	<button type="submit" class="btn btn-success"><?=$titleBouton?></button>
</form>