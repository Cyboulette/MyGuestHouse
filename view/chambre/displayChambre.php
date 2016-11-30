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
  		//TODO : pouvoir recuperer les liens :(
  	}else{
  		echo '<div class="alert alert-danger">'."il n'y a aucune photo pour linstant".'</div>';
  	}
  ?>

  <?php 
  	// description de la chambre
  	echo "
		<div class='descriptionChambre'>
			<div>
				<h4>Description :<h4>
			</div>
			<ul>
				<li>
					Nom de la chambre : {$nom}
				</li>
				<li>
					Prix<small>/nuit</small> : {$prix}&euro;
				</li>
				<li>
					Suerficie : {$superficie}m<sup>2</sup>
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
  	//TODO : details
  ?>

  <?php
  	//TODO : prestation
  ?>

  <?php
  	//TODO : calandar -> resarvation
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







