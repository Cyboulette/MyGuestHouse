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


  	<h1 class='page-header'><?=$prenom?> <?=$nom?></h1>

  		<p><h4>Modification de l'utilisateur :</h4></p> 
  		</br>
    	
    	<form class='col-xs-offset-1' method='post' action='?controller=adminUtilisateurs&action=edited&idUtilisateur={$id}' enctype='multipart/form-data'>

      		<div class='form-group row'>
          		<label for='id_email' class='col-sm-3 control-label'>E-mail : </label>
          		<div class="col-sm-9">
          			<?php  echo "<input class='form-control' type='email' name='email' id='id_email' value='{$email}'>"; ?>       		
          		</div>
      		</div>

          <div class='form-group row'>
            <label for='id_prenom' class='col-sm-3 control-label'>Prenom de l'utilisateur : </label>
            <div class="col-sm-9">
                <?php echo "<input class='form-control' type='text' value='{$prenom}' name='prenom' id='id_prenom'>"; ?>
            </div>
          </div>
          
      		<div class='form-group row'>
      			<label for='id_nom' class='col-sm-3 control-label'>Nom de l'utilisateur : </label>
          		<div class="col-sm-9">
          			<?php echo "<input class='form-control' type='text' value='{$nom}' name='nom' id='id_nom'>"; ?>
          		</div>
      		</div>
      		
      		<div class='form-group row'>
            <label class='col-sm-3 control-label' for='id_rang'>Rang de l'utilisateur :</label>
            <div class="col-sm-9">
      				<select multiple class='form-control'  name='rang' id='id_rang'>
      					<?php echo "<option value='1' {$rang1}>Visiteur</option>"; ?>
      					<?php echo "<option value='2' {$rang2}>Membre</option>"; ?>
      					<?php echo "<option value='3' {$rang3}>Administrateur</option>"; ?>
      				</select>
            </div>
    			</div>

      		<div class='col-xs-6 col-sm-5 col-lg-3 clear-both-left'>
        		<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
        		<?php echo"<input type='hidden' value='{$id}' name='id'>" ?>
      		</div>
    	</form>
    	</br>
    	</br>
    	</br>



		<h4>Changement de mot de passe :</h4>
		</br>

		<form class='col-xs-offset-1' method='post' action='' enctype='multipart/form-data'>

    		<div class='form-group row'>
        		<label for='id_ancienMDP' class='col-sm-3 control-label'>Ancien mot de passe : </label>
        		<div class="col-sm-9">
        			<input class='form-control' type='password' name='ancienMDP' id='id_ancienMDP' placeholder='ancien mot de passe'>        		
        		</div>
      		</div>

    		<div class='form-group row'>
    			<label for='id_nouveauMDP' class='col-sm-3 control-label'>Nouveau mot de passe : </label>
        		<div class="col-sm-9">
        			<input class='form-control' type='password' name='nouveauMDP' id='id_nouveauMDP' placeholder='nouveau mot de passe'>
        		</div>
      		</div>

      		<div class='form-group row'>
        		<label for='id_nouveauMDPbis' class='col-sm-3 control-label'>Validation du mot de passe : </label>
        		<div class="col-sm-9">
          			<input class='form-control' type='password' name='nouveauMDPbis' id='id_nouveauMDPbis' placeholder='validation du mot de passe'>
        		</div>
      		</div>

      		<div class='col-xs-6 col-sm-5 col-md-3 clear-both-left'>
        		<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
        		<?php echo "<input type='hidden' value='{$id}' name='id'>"; ?>
      		</div>
    	</form>


	