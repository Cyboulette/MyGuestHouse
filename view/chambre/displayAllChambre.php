<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-2 ol-lg-offset-3 text-center">
  <?php
  	if (isset($tab_v) && !empty($tab_v)) {
      echo '<h1>Nos chambres</h1>';
  		echo'<div class="row placeholders">';
		  	foreach ($tab_v as $chambre){
		  		$nom = $chambre->get("nomChambre");
		  		$prix = $chambre->get("prixChambre");
          $id = $chambre->get("idChambre");
		        echo "
              <a href='?controller=chambre&action=read&idChambre=$id'>
  		       		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 placeholder'>
                  <img src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' width='750' height='750' class='img-responsive' alt='Generic placeholder thumbnail'>
         		 			<h4>{$nom}</h4>
          				<span class='text-muted'>{$prix} <span class='glyphicon glyphicon-eur' aria-hidden='true'></span></span>
      				  </div>
              </a>
		        ";
		    }
		  echo '</div>';	
  	}else{
  		echo '<div class="alert alert-danger">'."Il n'y a aucune chambre pour l'instant".'</div>';
  	}
  ?>
</div>