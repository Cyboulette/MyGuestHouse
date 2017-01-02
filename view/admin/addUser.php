<?php if(!$powerNeeded) { exit(); } ?> 

<?php 
  	echo "<h1 class='page-header'>Ajouter un utilisateur</h1>";
  	echo "
    	<form method='post' action='?controller=adminUtilisateurs&action=added' enctype='multipart/form-data'>

    		<div class='form-group row'>
      		<label for='id_email' class='col-xs-3 col-form-label'>E_mail : </label>
      		<div class='col-xs-3'>
        		<input type='email' name='email' placeholder='email@email.com' id='id_email'>        		
        	</div>
      	</div>

    		<div class='form-group row'>
    			<label for='id_prenom' class='col-xs-3 col-form-label'>Prenom de l'utilisateur : </label>
        	<div class='col-xs-3'>
        		<input type='text' name='prenom' placeholder='Florian' id='id_nom'>
        	</div>
      	</div>

        <div class='form-group row'>
          <label for='id_nom' class='col-xs-3 col-form-label'>Nom de l'utilisateur : </label>
          <div class='col-xs-3'>
            <input type='text' name='nom' placeholder='POIROT' id='id_nom'>
          </div>
        </div>

      	<div class='form-group row'>
    			<select multiple class='form-control' name='rang' id='id_rang'>
    				<label for='id_rang'>Rang de l'utilisateur</label>
    				<option value='1'>Visiteur</option>
    				<option value='2'>Membre</option>
    				<option value='3'>Administrateur</option>
    			</select>
    		</div>

        <div class='form-group row'>
          <label for='id_motDePasse' class='col-xs-3 col-form-label'>Mot de passe : </label>
          <div class='col-xs-3'>
            <input type='password' name='motDePasse' id='id_motDePasse' placeholder='nouveau mot de passe'>
          </div>
        </div>

        <div class='form-group row'>
          <label for='id_motDePassebis' class='col-xs-3 col-form-label'>Validation du mot de passe : </label>
          <div class='col-xs-3'>
              <input type='password' name='motDePassebis' id='id_motDePassebis' placeholder='validation du mot de passe'>
          </div>
        </div>

        <div class='col-xs-6 col-sm-5 col-md-2'>
          <input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
        </div>
    </form>
 	";
?>

	