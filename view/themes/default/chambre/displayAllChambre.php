<div>
	<?php if(isset($tab_v) && !empty($tab_v)) { ?>

	<h1 class="page-header">Nos chambres</h1>
	<div class="placeholders">

		<?php foreach ($tab_v as $chambre){
			$nom = htmlspecialchars($chambre->get("nomChambre"));
			$prix = htmlspecialchars($chambre->get("prixChambre"));
			$id = htmlspecialchars($chambre->get("idChambre"));
			$latestPhoto = $chambre->selectPhoto(true);

			if($latestPhoto != false && file_exists(File::build_path(array($latestPhoto['urlVisuel'])))) {
				$image = $latestPhoto['urlVisuel'];
			} else {
				$image = 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
			}
		?>

		<div class="row margin-bottom-30px" style="border: solid black 1px; border-radius: 2px;%">
			<div class="container margin-top-30px margin-bottom-30px">
				<h3 class="text-center margin-bottom-30px"><?=$nom?></h3>
				<div class='col-xs-10 col-sm-4 col-md-4 col-lg-4 margin-bottom-30px'>
					<a class="" href='?controller=chambre&action=read&idChambre=<?=$id?>' ><img src='<?=$image?>' class='img imgChambreDA'></a>
				</div>

				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 margin-top-30px margin-bottom-30px" >
					<p>Description</p>
					<p><span class='text-muted'><?=$prix?> <span class='glyphicon glyphicon-eur' aria-hidden='true'></span></span> <a href='?controller=chambre&action=read&idChambre=<?=$id?>' >Voir en détail</a></p>
					<p class="text-danger">Réservée jusqu'au </p>
				</div>
			</div>
		</div>

		<?php } ?>

	</div>

  	<?php } else { ?>

		<div class="alert alert-danger">Il n\'y a aucune chambre pour l\'instant</div>

	<?php } ?>

</div>