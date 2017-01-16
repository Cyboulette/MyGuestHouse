<?php if(!$powerNeeded) { exit(); } ?>

<?php   
  // variables 
  $nom = $chambre->get("nomChambre"); 
  $prix = $chambre->get("prixChambre"); 
  $superficie = $chambre->get("superficieChambre"); 
  $description = nl2br($chambre->get("descriptionChambre"));
  //id
  $id = $chambre->get("idChambre");

  $avis = ModelAvis::selectCustomAvis('idChambre', $id);
  $nbAvis = ModelAvis::countCustomAvis('idChambre', $id);
  if($nbAvis>1){
    $SOfAvis = 's';
  }else{
    $SOfAvis =  '';
  }
?> 
 
 

<h1 class='page-header'><?=$nom?></h1>
<?php if(isset($message)) echo $message; ?>


 
<?php  
  //photo avec une futur carousel 
  if (isset($tab_photo) && !empty($tab_photo)) { 
    echo "
      <div id='myCarousel' class='carousel slide' data-ride='carousel'>
        <ol class='carousel-indicators'>
      ";


    foreach ($tab_photo as $key => $value) { 
      
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
      $photo = $value['urlVisuel'];
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
    echo '<div class="alert alert-danger">'."Il n'y a aucune photo pour l'instant".'</div>'; 
  } 
?> 
 
 
<?php  
  // description de la chambre 
  echo " 
    <div class='descriptionChambre margin-top-30px'> 
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
    <a href='index.php?controller=adminChambres&action=editChambre&idChambre={$id}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier les informations</a>
  "; 
?>
 
<?php 
  // Details de la chambre 
  if (isset($tab_detail) && !empty($tab_detail)) { 
    echo "<div class ='margin-top-30px'>"; 
     
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
        <a target="_blank" href="index.php?controller=adminDetails&action=manageDetails&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les détails</a>
      </div>
      
    '; 
  }else{ 
    echo '
      <div class ="margin-top-30px">
        <div class="alert alert-danger">'."il n'y a pas de details pour cette chambre".'</div>
        <a href="index.php?controller=adminDetails&action=manageDetails&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les détails</a>
    '; 
  } 
?> 
 
<?php 
  // Prestations de la chambre 
  if (isset($tab_prestation) && !empty($tab_prestation)) { 
    echo "<div class ='margin-top-30px'>"; 
     
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
        <a target="_blank" href="index.php?controller=adminPrestations&action=managePrestations&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les prestations</a>
      </div>
    '; 
  }else{ 
    echo '
      <div class ="margin-top-30px">
        <div class="alert alert-danger">'."il n'y a pas de prestations pour cette chambre".'</div>
        <a href="index.php?controller=adminPrestations&action=managePrestations&idChambre='.$id.'" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier les prestations</a>
      </div>
    '; 
  } 
?> 

  <div class="panel-group margin-top-30px" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <div class="space-for-according">
              <span class="text-left">Détails sur les avis</span><span class="text-right"><?=$nbAvis?> avis enregistré<?=$SOfAvis?></span>
            </div>
          </a>
        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">


        <?php 
          if($nbAvis != 0){
            foreach ($avis as $key => $value) {
              $note = $value->get('note');
              $commentaire = nl2br($value->get('commentaire'));
              $idUtilisateur = $value->get('idUtilisateur');
              $idChambre = $value->get('idChambre');

              $utilisateur = ModelUtilisateur::select($idUtilisateur);
              $nomUtilisateur = $utilisateur->get('nomUtilisateur');
              $prenomUtilisateur = $utilisateur->get('prenomUtilisateur');
        ?>
              <div class="row border-avis">
                <div class='descriptionChambre'>  
                  <ul> 
                    <li class="no-puce"> 
                      Avis de : <?=$prenomUtilisateur?> <?=$nomUtilisateur?>
                    </li> 
                    <li class="no-puce"> 
                      Note : 
                    <?php  
                      if( is_numeric($note) && $note>=0 && $note<=5){
                        for ($i=0; $i<$note ; $i++) { 
                    ?>
                          <i class="fa fa-star" aria-hidden="true"></i>
                    <?php     
                        }
                        for ($i=0; $i < (5-$note) ; $i++) { 
                    ?>
                          <i class="fa fa-star-o" aria-hidden="true"></i>
                    <?php
                        }

                      }
                    ?>
                      <small>(<?=$note?>/5)</small>
                    </li> 
                    <li class="no-puce"> 
                      Avis : 
                      <ul> 
                        <li class="no-puce border"><?=$commentaire?></li> 
                      </ul> 
                    </li> 
                  </ul>   
                    <?php echo "<a href='?controller=AdminAvis&action=edit&idUtilisateur={$idUtilisateur}&idChambre={$idChambre}&from=chambre' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>"; ?> 
                    <?php echo "<a href='?controller=AdminAvis&action=delete&idUtilisateur={$idUtilisateur}&idChambre={$idChambre}&from=chambre' class='btn btn-xs btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i> Supprimer</a>" ?>
                </div>
              </div>


        <?php
            }
          }else{
        ?>
            <div class="alert alert-danger">Cette chambre ne possede pas encore d'avis !</div>
        <?php
          }
        ?>

        </div>
      </div>
    </div>
  </div>