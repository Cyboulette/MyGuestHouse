<?php
if(!empty($dataSlides)) {
$classAditional = '';
?>
<div class="jumbotron text-center">
	<div id="carousel-accueil" class="carousel slideAccueil slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
		<?php 
			foreach($dataSlides as $slide) {
			$isActive = ($slide['order'] == 0 ? 'class="active"' : '');
		?>
			<li data-target="#carousel-accueil" data-slide-to="<?=$slide['order']?>" <?=$isActive?>></li>
		<?php } ?>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">
		<?php
			foreach($dataSlides as $slide) {
			$isActive = ($slide['order'] == 0 ? 'active' : '');
		?>
			<div class="item <?=$isActive?>">
				<img src="<?=$slide['url']?>" alt="">
				<div class="carousel-caption">
					<div class="full-width text-center">
						<p><?=nl2br($slide['texte'])?></p>
					</div>
				</div>
			</div>
		  <?php } ?>
	  </div>

	  <!-- Controls -->
	  <a class="left carousel-control" href="#carousel-accueil" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Image précédente</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-accueil" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Image Suivante</span>
	  </a>
	</div>
</div>
<?php } else {
	$classAditional = 'page';
} ?>

<div class="container <?=$classAditional?>">
	<div class="row rooms">
		<div class="col-lg-12 titleRoom">
			<h1 class="colorCustom">Nos chambres</h1>
			<em>Découvrez quelques-unes de nos chambres et leurs tarifs !</em>
		</div>

		<div class="col-lg-12">
		<?php 
			if(empty($listChambres)) {
				echo '<div class="alert alert-info">Notre site ne possède aucune chambre pour le moment</div>';
			} else {
				$count = 0;
				foreach ($listChambres as $chambre) {
					if($count < 4) {
					$idChambre = htmlspecialchars($chambre->get('idChambre'));
					$nomChambre = htmlspecialchars($chambre->get('nomChambre'));
					$descriptionChambre = ControllerDefault::truncate(htmlspecialchars($chambre->get('descriptionChambre')), 255);
					$prixChambre = htmlspecialchars($chambre->get('prixChambre'));
					$latestPhoto = $chambre->selectPhoto(true);
					if($latestPhoto != false) {
						if(file_exists(File::build_path(array($latestPhoto['urlVisuel'])))) {
							$image = '<img data-mh="group-img" src="'.$latestPhoto['urlVisuel'].'" class="img-responsive" alt="">';
						} else {
							$image = '<div data-mh="group-img" class="alert alert-info text-center">Nous ne disposons d\'aucune photo pour cette chambre</div>';
						}
					} else {
						$image = '<div data-mh="group-img" class="alert alert-info text-center">Nous ne disposons d\'aucune photo pour cette chambre</div>';
					}
				?>
					<div class="col-md-3 room">
						<div class="room-img"><?=$image?></div>
						<div class="room-text">
							<h2 class="colorCustom"><?=$nomChambre?></h2>
							<p data-mh="group-desc"><?=$descriptionChambre?></p>
							<div class="room-buttons">
								<a href="index.php?controller=chambre&action=read&idChambre=<?=$idChambre?>" class="btn btn-lg btn-red bgCustom">Détails</a>
								<p class="colorCustom"><?=$prixChambre?> € <span>Par nuit</span></p>
							</div>
						</div>
					</div>
				<?php }
				$count++;
				}
			}
		?>
		</div>
	</div>

	<div class="row rooms">
		<div class="col-lg-12 titleRoom">
			<h1 class="colorCustom">Nos Prestations</h1>
			<em>Vous ne louez pas seulement une chambre ! Mais aussi des prestations</em>
		</div>

		<div class="col-lg-12">
			<div class="col-lg-6">
				<p>
					Découvrez au sein de notre chambre d'hôtes des prestations qui pourront accompagner votre séjour chez nous !<br/>
					Ces prestations peuvent-être directement comprises dans la formule d'hébergement, afin de correspondre au mieux à <b>vos besoins</b><br/><br/>
					Retrouvez donc un service amélioré dans nos chambres d'hôtes !
				</p>
			</div>
			<div class="col-lg-6 text-center">
				<div class="col-md-5">
					<div class="service">
						<h2><i class="fa fa-bed" aria-hidden="true"></i></h2>
						<b>Une chambre ...</b>
					</div>
				</div>
				<div class="col-md-5">
					<div class="service">
						<h2><i class="fa fa-cutlery" aria-hidden="true"></i></h2>
						<b>... des prestations</b>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		if($display_news == 'true') { 
	?>
	<div class="row rooms">
		<div class="col-lg-12 titleRoom">
			<h1 class="colorCustom">Notre actualité</h1>
			<em>Découvrez les dernières nouveautés de notre chambre d'hôtes !</em>
		</div>

		<div class="col-lg-12">
			<?php
				setlocale(LC_ALL, 'fr_FR');
				foreach ($listNews as $news) {
				if($news->get('publie') == 1) {
				$date = date_create($news->get('dateNews'));
				$dateDisplay = date_format($date, 'd M');
				$idNews = htmlspecialchars($news->get('idNews'));
				$titreNews = htmlspecialchars($news->get('titreNews'));
			?>
				<div class="col-lg-6 news">
					<div class="col-md-2 text-center">
						<div class="calendar bgCustom">
							<?=$dateDisplay?>
						</div>
					</div>
					<div class="col-md-10">
						<b><?=$titreNews?></b><br/>
						<a href="index.php?controller=news&action=read&idNews=<?=$idNews?>" class="btn btn-red btn-xs bgCustom">Lire la news</a>
					</div>
					<hr/>
				</div>
			<?php } } ?>
		</div>
	</div>
	<?php } ?>
</div>






