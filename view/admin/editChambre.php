<?php if(!$powerNeeded) { exit(); } ?>


<?php   
  // variables 
  $nom = $chambre->get("nomChambre"); 
  $prix = $chambre->get("prixChambre"); 
  $superficie = $chambre->get("superficieChambre"); 
  $description = $chambre->get("descriptionChambre"); 
?> 

<!-- description de la chambre -->
<?php 
  echo "<h1 class='page-header'>{$nom}</h1>";
  echo "
    <form method='post' action='index.php?controller=admin&action=editedChambre' enctype='multipart/form-data'>

      <div class='form-group row'>
        <label for='id_nom' class='col-xs-3 col-form-label'>Nom de la chambre : </label>
        <div class='col-xs-3'>
          <input type='text' value='{$nom}' name='nom' id='id_nom'>
        </div>
      </div>

      <div class='form-group row'>
        <label for='id_prix' class='col-xs-3 col-form-label'>Prix<small>/nuit</small> : </label>
        <div class='col-xs-3'>
          <input type='number' min='0' value='{$prix}' name='prix' id='id_prix'>&euro;
        </div>
      </div>
              
      <div class='form-group row'>
        <label for='id_superficie' class='col-xs-3 col-form-label'>Superficie : </label>
        <div class='col-xs-3'>
          <input type='number' min='0' value='{$superficie}' name='prix' id='id_superficie'>m<sup>2</sup> 
        </div>
      </div>
                
      <div class='form-group'>
        <label for='exampleTextarea'>Description : </label>
        <textarea class='form-control' id='exampleTextarea' rows='3'>{$description} </textarea>
      </div>

      <div class='col-xs-6 col-sm-5 col-md-2'>
        <input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
      </div>
    </form>

    <div class='col-xs-6 col-sm-5 col-md-2'>
      <a href='?controller=admin&action=chambres' class='btn btn-s btn-danger btn-block'>Annuler</a>
    </div>
  "; 
?>





