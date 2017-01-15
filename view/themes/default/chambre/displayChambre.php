<div>
   
    <?php   
        // variables 
        $nom = $chambre->get("nomChambre"); 
        $prix = $chambre->get("prixChambre"); 
        $superficie = $chambre->get("superficieChambre"); 
        $description = nl2br($chambre->get("descriptionChambre"));
        $id = $chambre->get('idChambre');

        $avis = ModelAvis::selectCustomAvis('idChambre', $id);
        $nbAvis = ModelAvis::countCustomAvis('idChambre', $id);
        if($nbAvis>1){
          $SOfAvis = 's';
        }else{
          $SOfAvis =  '';
        }
        $listeChambreForAvis = ModelAvis::listeChambresPourAvis($id);

        $canPosteReviews = false;

        if(ControllerUtilisateur::isConnected()){
          $utilisateurExists = ModelUtilisateur::select($_SESSION['idUser']);
          if($utilisateurExists!=false){
            if(ModelAvis::canPosteReviews($_SESSION['idUser'], $id)){
              $canPosteReviews = true;
              $idUtilisateur = $_SESSION['idUser'];
            }
          }
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
          echo '<div class="alert alert-danger">'."Il n'y a aucune photo pour linstant".'</div>';
        } 
    ?> 
 
 
    <?php  
        // description de la chambre 
        echo " 
            <div class='descriptionChambre margin-top-30px'>
                <h3>Description </h3>
                <ul class='no-puce margin-bottom-30px'>
                    <li> {$description} </li>
                </ul>
                <h3>Caractéristiques</h3>
                <ul class='no-puce margin-bottom-30px'>
                    <li> Prix<small>/nuit</small> : {$prix}&euro; </li>
                    <li> Superficie : {$superficie}m<sup>2</sup> </li>
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
                <h3>Détails </h3>
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
          echo '<div class="alert alert-danger">'."Il n'y a pas de details pour cette chambre".'</div>';
        } 
    ?> 
 
 
    <?php 
        // Prestations de la chambre 
        if (isset($tab_prestation) && !empty($tab_prestation)) { 
          echo "<div>"; 
     
            echo " 
              <div> 
                <h3>Prestation </h3>
              </div> 
              <div> 
                <ul class='no-puce'>
            "; 
     

            foreach ($tab_prestation as $prestation) {
              $nom = $prestation->get('nomPrestation');
              $prix = $prestation->get('prix');
              echo "<li>".ucfirst($nom)." : ".$prix."&euro;</li>";
            }
     
            echo " 
                </ul> 
              </div> 
            "; 
     
          echo "</div>"; 
        }else{ 
          echo '<div class="alert alert-danger">'."Il n'y a pas de prestations pour cette chambre".'</div>';
        } 
    ?> 

    <div class="text-center"><a class="btn btn-success btn-lg" href="index.php?controller=reservation&action=reservationChambre&idChambre=<?=$id?>"><i class="fa fa-calendar" aria-hidden="true"></i> Réserver cette chambre</a></div>
    <hr/>

  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <div class="space-for-according">
              <span class="text-left">Détails sur les avis</span><span class="text-right"><?= $nbAvis?> avis enregistré<?=$SOfAvis?></span>
            </div>
          </a>
        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">

          <?php 
            if($canPosteReviews){       
          ?>  
              <div class="row border-avis margin-bottom-30px">
                <h2 class='text-center'>Ajouter un avis a nos chambres</h2>
                <?php echo "<form class='form-horizontal' method='post' action='index.php?controller=avis&action=add&forChambre={$id}'>"; ?>

                  <div class="form-group row">
                      <label for="id_note" class="col-xs-2 control-label">Note :</label>
                      <div class="col-xs-10">
                        <input type="number" min="0" max="5" class="form-control" placeholder='0..5' name="note" id="id_note">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="id_avis" class="col-xs-2 control-label">Avis :</label>
                      <div class="col-xs-10">
                        <textarea id="id_avis" name="avis" placeholder='Votre avis sur la chambre !' class="form-control"></textarea>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-success" value="Ajouter">
                        <input type="hidden" name="idUtilisateur" value=<?=$idUtilisateur?>>
                        <input type="hidden" name="idChambre" value=<?=$id?>>
                      </div>
                  </div>
                </form>
              </div>

          <?php
            }
          ?>

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
                  <?php
                    if(ControllerUtilisateur::isConnected() && $_SESSION['idUser']==$idUtilisateur){
                      echo "<a href='?controller=utilisateur&action=profil' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>"; 
                    }
                  ?>
                  </div>
                </div>


          <?php
              }
            }else{
          ?>
              <div class="alert alert-danger">Cette chambre ne possède pas encore d'avis !</div>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>



</div> 