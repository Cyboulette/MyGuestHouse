<?php if(!$powerNeeded) { exit(); } ?>

<?php   
  // variables 
  $nom = $chambre->get("nomChambre"); 
  $prix = $chambre->get("prixChambre"); 
  $superficie = $chambre->get("superficieChambre"); 
  $description = $chambre->get("descriptionChambre");
  //id
  $id = $chambre->get("idChambre"); 
?> 
 
 
<?php 
  // titre de la page 
  echo "<h1 class='page-header'>{$nom}</h1>";
?> 

 
<?php  
  //photo avec une futur carousel 
  if (isset($tab_photo) && !empty($tab_photo)) { 
    echo "
      <div id='myCarousel' class='carousel slide' data-ride='carousel'>
        <ol class='carousel-indicators'>
      ";


    foreach ($tab_photo as $key => $value) { 
      $photo = $tab_photo[$key][0];
      echo "
        <li data-target='#myCarousel' data-slide-to=$key
      ";
      if ($key == 0) {
        echo "
          class='active'></li>
        ";
      }else{
        echo "
          ></li>
        ";
      }
    } 

    echo "
        </ol>
      <div class='carousel-inner' role='listbox'>
    ";

    foreach ($tab_photo as $key => $value) { 
      $photo = $tab_photo[$key][0];
      echo "
        <div class='item  
      ";
      if ($key == 0) {
        echo "
          active'>
            <img src='{$photo}'>
          </div>
        ";
      }else{
        echo "
            '>
            <img src='{$photo}'>
          </div>
         ";
      }
    }

    echo "
      </div>
        <a class='left carousel-control' href='#myCarousel' role='button' data-slide='prev'>
          <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
          <span class='sr-only'>Previous</span>
        </a>
        <a class='right carousel-control' href='#myCarousel' role='button' data-slide='next'>
          <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
          <span class='sr-only'>Next</span>
        </a>
      </div>
    ";
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
    <a href='index.php?controller=adminChambres&action=editChambre&idChambre={$id}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier la chambre</a>
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
     
    echo '
      </div>
      <a target="_blank" href="index.php?controller=adminDetails&action=manageDetails&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les détails</a>
    '; 
  }else{ 
    echo '
      <div class="alert alert-danger">'."il n'y a pas de details pour cette chambre".'</div>
      <a href="index.php?controller=adminDetails&action=manageDetails&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les détails</a>
    '; 
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
     

    foreach ($tab_prestation as $prestation) {
      $nom = $prestation->get('nomPrestation');
      $prix = $prestation->get('prix');
      echo "<li>".$nom." : ".$prix."&euro;</li>"; 
    }
     
    echo " 
        </ul> 
      </div> 
    "; 
     
    echo '
      </div>
      <a target="_blank" href="index.php?controller=adminPrestations&action=managePrestations&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les détails</a>
    '; 
  }else{ 
    echo '
      <div class="alert alert-danger">'."il n'y a pas de prestations pour cette chambre".'</div>
      <a href="index.php?controller=adminPrestations&action=managePrestations&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les détails</a>
    '; 
  } 
?> 

  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <div class="space-for-according">
              <span class="text-left">Détails sur les avis</span><span class="text-right"><?php echo "X"; ?> avi(s) enregistré(s)</span>
            </div>
          </a>
        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
        </div>
      </div>
    </div>
  </div>