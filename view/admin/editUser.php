<?php if(!$powerNeeded) { exit(); } ?> 

<?php
	if(!isset($utilisateur)){
        exit();
    }else{
    	$id = $utilisateur->get('idUtilisateur');
        $nom = $utilisateur->get('nomUtilisateur');
        $prenom = $utilisateur->get('prenomUtilisateur');
        $email = $utilisateur->get('emailUtilisateur');
	    $rang = $utilisateur->get('rang') ;
	    $statut = $utilisateur->get('nonce');

	    if($statut != null){
	    	$statut = 'Non activé';
	    }else{
	    	$statut = 'Activé';
	    }

        if($rang=='1'){
        	$rang1="selected='selected'";
        	$rang2='';
        	$rang3='';
        }else if($rang=='2'){
        	$rang1='';
        	$rang2="selected='selected'";
        	$rang3='';
        }else if($rang=='3'){
        	$rang1='';
        	$rang2='';
        	$rang3="selected='selected'";
        }
    }
?>

<?php 
  	echo "<h1 class='page-header'>{$prenom} {$nom}</h1>";
  	echo "
  		<p><h4>Modification de l'utilisateur :</h4></p> 
  		</br>
    	
    	<form method='post' action='?controller=adminUtilisateurs&action=edited&idUtilisateur={$id}' enctype='multipart/form-data'>

      		<div class='form-group row'>
          		<label for='id_email' class='col-xs-3 col-form-label'>E_mail : </label>
          		<div class='col-xs-3'>
          			<input type='email' name='email' id='id_email' value='{$email}'>        		
          		</div>
      		</div>

      		<div class='form-group row'>
      			<label for='id_nom' class='col-xs-3 col-form-label'>Nom de l'utilisateur : </label>
          		<div class='col-xs-3'>
          			<input type='text' value='{$nom}' name='nom' id='id_nom'>
          		</div>
      		</div>

      		<div class='form-group row'>
        		<label for='id_prenom' class='col-xs-3 col-form-label'>Prenom de l'utilisateur : </label>
        		<div class='col-xs-3'>
          			<input type='text' value='{$prenom}' name='prenom' id='id_prenom'>
        		</div>
      		</div>
              
      		
                
      		<div class='form-group row'>
    				<select multiple class='form-control' name='rang' id='id_rang'>
    					<label for='id_rang'>Rang de l'utilisateur</label>
    					<option value='1' {$rang1}>Visiteur</option>
    					<option value='2' {$rang2}>Membre</option>
    					<option value='3' {$rang3}>Administrateur</option>
    				</select>
    			</div>

      		<div class='col-xs-6 col-sm-5 col-md-2'>
        		<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
        		<input type='hidden' value='{$id}' name='id'>
      		</div>
    	</form>
    	</br>
    	</br>
    	</br>
 	";

  	echo "
		<h4>Changement de mot de passe :</h4>
		</br>

		<form method='post' action='' enctype='multipart/form-data'>

    		<div class='form-group row'>
        		<label for='id_ancienMDP' class='col-xs-3 col-form-label'>Ancien mot de passe : </label>
        		<div class='col-xs-3'>
        			<input type='password' name='ancienMDP' id='id_ancienMDP' placeholder='ancien mot de passe'>        		
        		</div>
      		</div>

    		<div class='form-group row'>
    			<label for='id_nouveauMDP' class='col-xs-3 col-form-label'>Nouveau mot de passe : </label>
        		<div class='col-xs-3'>
        			<input type='password' name='nouveauMDP' id='id_nouveauMDP' placeholder='nouveau mot de passe'>
        		</div>
      		</div>

      		<div class='form-group row'>
        		<label for='id_nouveauMDPbis' class='col-xs-3 col-form-label'>Validation du mot de passe : </label>
        		<div class='col-xs-3'>
          			<input type='password' name='nouveauMDPbis' id='id_nouveauMDPbis' placeholder='validation du mot de passe'>
        		</div>
      		</div>

      		<div class='col-xs-6 col-sm-5 col-md-2'>
        		<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
        		<input type='hidden' value='{$id}' name='id'>
      		</div>
    	</form>
	";
?>

	