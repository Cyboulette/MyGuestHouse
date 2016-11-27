<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
  <?php
  	if (isset($tab_v) && !empty($tab_v)) {
  		echo'<div class="row placeholders">';
		  	foreach ($tab_v as $chambre){
		  		$nom = $chambre->get("nomChambre");
		  		$prix = $chambre->get("prixChambre");
		        echo "
		       		<div class='col-xs-6 col-sm-3 placeholder'>
    					<img src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' width='200' height='200' class='img-responsive' alt='Generic placeholder thumbnail'>
       		 			<h4>{$nom}</h4>
        				<span class='text-muted'>{$prix}</span>
    				</div>
		        ";
		    }
		echo '</div>';	
  	}else{
  		echo '<div class="alert alert-danger">'."il n'y a aucune chambre pour linstant".'</div>';
  	}
  ?>
</div>