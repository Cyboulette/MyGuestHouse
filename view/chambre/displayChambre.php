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
     

            foreach ($tab_prestation as $prestation) {
              $nom = $prestation->get('nomPrestation');
              $prix = $prestation->get('prix');
              echo "<li>".$nom." : ".$prix."&euro;</li>"; 
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