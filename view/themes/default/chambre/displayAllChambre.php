<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2"> 
  <?php
  	if (isset($tab_v) && !empty($tab_v)) {
      echo '<h1 class="page-header">Nos chambres</h1>'; 
  		echo'<div class="row placeholders">';
		  	foreach ($tab_v as $chambre){
		  		$nom = htmlspecialchars($chambre->get("nomChambre"));
		  		$prix = htmlspecialchars($chambre->get("prixChambre"));
          $id = htmlspecialchars($chambre->get("idChambre"));
          $latestPhoto = $chambre->selectPhoto(true);
          if($latestPhoto != false && file_exists(File::build_path(array($latestPhoto['urlVisuel'])))) {
            $image = $latestPhoto['urlVisuel'];
          } else {
            $image = 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
          }
		        echo "
              <a href='?controller=chambre&action=read&idChambre=$id'>
  		       		<div class='col-xs-12 col-sm-10 col-md-4 col-lg-4 placeholder' data-mh='chambre-da'>
                  <img src='".$image."' class='img-responsive imgChambreDA'>
         		 			<h4>{$nom}</h4>
          				<span class='text-muted'>{$prix} <span class='glyphicon glyphicon-eur' aria-hidden='true'></span></span>
      				  </div>
              </a>
		        ";
		    }
		  echo '</div>';	
  	}else{
  		echo '<div class="alert alert-danger">Il n\'y a aucune chambre pour l\'instant</div>';
  	}
  ?>
</div>