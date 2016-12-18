<?php if(!$powerNeeded) { exit(); } ?>

<?php 
  echo "<h1 class='page-header'>Ajouter une chambre</h1>";
  echo "
    <form method='post' action='index.php?controller=admin&action=addedChambre' enctype='multipart/form-data'>

      <div class='form-group row'>
        <label for='id_nom' class='col-xs-3 col-form-label'>Nom de la chambre : </label>
        <div class='col-xs-3'>
          <input type='text' placeholder='Nom' name='nom' id='id_nom'>
        </div>
      </div>

      <div class='form-group row'>
        <label for='id_prix' class='col-xs-3 col-form-label'>Prix<small>/nuit</small> : </label>
        <div class='col-xs-3'>
          <input type='number' min='0' placeholder='Prix' name='prix' id='id_prix'>&euro;
        </div>
      </div>
              
      <div class='form-group row'>
        <label for='id_superficie' class='col-xs-3 col-form-label'>Superficie : </label>
        <div class='col-xs-3'>
          <input type='number' min='0' placeholder='Superficie' name='superficie' id='id_superficie'>m<sup>2</sup> 
        </div>
      </div>

      <div class='form-group'>
        <label for='exampleTextarea'>Description : </label>
        <textarea class='form-control' placeholder='Description' id='exampleTextarea' name='description' rows='3'></textarea>
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