<div class="col-sm-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2"> 
  <?php
  	if (isset($tab_v) && !empty($tab_v)) {
      echo '<h1 class="page-header">Nos chambres</h1>'; 
  		echo'<div class="row text-center">';
		  	foreach ($tab_v as $chambre) {
		  		$nom = htmlspecialchars($chambre->get("nomChambre"));
		  		$prix = htmlspecialchars($chambre->get("prixChambre"));
				$id = htmlspecialchars($chambre->get("idChambre"));
				$latestPhoto = $chambre->selectPhoto(true);
				if($latestPhoto != false && file_exists(File::build_path(array($latestPhoto['urlVisuel'])))) {
					$image = $latestPhoto['urlVisuel'];
				} else {
					$image = null;
					$noImage = '<div class="alert alert-info">Nous ne disposons d\'aucune photo pour cette chambre</div>';
				}
				echo "<a class='room' href='?controller=chambre&action=read&idChambre=$id'>
					<div class='col-md-4 col-sm-4 col-xs-5' data-mh='chambre-da'>";
					if($image == null) {
						echo $noImage;
					} else {
						echo "<img src='".$image."' class='img-responsive imgChambreDA'>";
					}
					echo "<h4>{$nom}</h4>
						<span class='text-muted'>{$prix} <span class='glyphicon glyphicon-eur' aria-hidden='true'></span></span>
					</div>
				</a>";
		    }
		  echo '</div>';	
  	} else {
  		echo '<div class="alert alert-danger">Il n\'y a aucune chambre pour l\'instant</div>';
  	}
  ?>
</div>