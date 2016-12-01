<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
  
  <?php  
  	// variables
  	$nom = $chambre->get("nomChambre");
  	$prix = $chambre->get("prixChambre");
  	$superficie = $chambre->get("superficieChambre");
  	$description = $chambre->get("descriptionChambre");
  ?>


  <?php
  	// titre de la page
    echo "<h1 class='page-header'>{$nom}</h1>";	
  ?>


  <?php 
  	//photo avec une futur carousel
  	if (isset($tab_photo) && !empty($tab_photo)) {
      echo "<div>";
        foreach ($tab_photo as $key => $value) {
          echo $tab_photo[$key][0].'</br>';
        }
      echo "</div>";
  	}else{
  		echo '<div class="alert alert-danger">'."il n'y a aucune photo pour linstant".'</div>';
  	}
  ?>


  <?php 
  	// description de la chambre
  	echo "
		<div class='descriptionChambre'>
			<div>
				<h4>Descriptions :<h4>
			</div>
			<ul>
				<li>
					Nom de la chambre : {$nom}
				</li>
				<li>
					Prix<small>/nuit</small> : {$prix}&euro;
				</li>
				<li>
					Superficie : {$superficie}m<sup>2</sup>
				</li>
				<li>
					Description :
					<ul>
						<li>
							{$description}
						</li>
					</ul>
				</li>
			</ul>
		</div>
  	";
  ?>


  <?php
  	// Details de la chambre
    if (isset($tab_detail) && !empty($tab_detail)) {
      echo "<div>";

        echo "
          <div>
            <h4>Détails :<h4>
          </div>
          <div>
            <ul>
        ";

        foreach ($tab_detail as $key => $value) {
          echo "<li>".$tab_detail[$key][0]." : ".$tab_detail[$key][1]."</li>";
        }

        echo "
            </ul>
          </div>
        ";

      echo "</div>";
    }else{
      echo '<div class="alert alert-danger">'."il n'y a pas de details pour cette chambre".'</div>';
    }
  ?>


  <?php
  	// Prestations de la chambre
    if (isset($tab_prestation) && !empty($tab_prestation)) {
      echo "<div>";

        echo "
          <div>
            <h4>Prestation :<h4>
          </div>
          <div>
            <ul>
        ";

        foreach ($tab_prestation as $key => $value) {
          echo "<li>".$tab_prestation[$key][0]." : ".$tab_prestation[$key][1]."</li>";
        }

        echo "
            </ul>
          </div>
        ";

      echo "</div>";
    }else{
      echo '<div class="alert alert-danger">'."il n'y a pas de prestations pour cette chambre".'</div>';
    }
  ?>

  <?php
  	//TODO : calendar -> resarvation
  ?>

  <?php
  	//TODO : bouton pour l'admin ???????
  ?>

</div>


<!-- description de la chambre en div -->
<!-- 
	<div>
		<p>- Nom de la chambre : {$nom}</p>
		<p>- Prix<small>/nuit</small> : {$prix}</p>
		<p>- Suerficie : {$superficie}</p>
		<div>
			<p>- Description : </p>
			<p>{$description}</p>
		</div>
	</div>
 -->




