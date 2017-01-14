<?php if(!$powerNeeded) { exit(); } ?> 

  	<h1 class='page-header'><?=$prenom?> <?=$nom?></h1>

		<div class="row">
			<h3>Modification de l'utilisateur </h3>
			<form method='post' action='index.php?controller=adminUtilisateurs&action=edited&idUtilisateur=<?=$id?>' enctype='multipart/form-data'>

				<div class='form-group'>
					<label for='id_email' class='control-label'>E-mail : </label>
					<input class='form-control' type='email' name='email' id='id_email' value=<?=$email?>>

				</div>

				<div class='form-group'>
					<label for='id_prenom'>Prenom de l'utilisateur : </label>
					<input class='form-control' type='text' value=<?=$prenom?> name='prenom' id='id_prenom'>

				</div>

				<div class='form-group'>
					<label for='id_nom' class='control-label'>Nom de l'utilisateur : </label>
					<input class='form-control' type='text' value=<?=$nom?> name='nom' id='id_nom'>

				</div>

				<div class='form-group'>
					<label class='control-label' for='id_rang'>Rang de l'utilisateur :</label>
					<select class='form-control'  name='rang' id='id_rang'>
						<option value='1' <?=$rang1?>>Visiteur</option>
						<option value='2' <?=$rang2?>>Membre</option>
						<option value='3' <?=$rang3?>>Administrateur</option>
					</select>
				</div>


				<div class='col-xs-6 col-sm-5 col-lg-3 clear-both-left'>
					<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
					<input type='hidden' value='<?=$id?>' name='id'>
				</div>

			</form>
		</div>




		<div class="row">
			<h3>Changement de mot de passe :</h3>

			<form method='post' action='' enctype='multipart/form-data'>

				<div class='form-group'>
					<label for='id_ancienMDP' class='control-label'>Ancien mot de passe : </label>
					<input class='form-control' type='password' name='ancienMDP' id='id_ancienMDP' placeholder='ancien mot de passe'>

				</div>

				<div class='form-group'>
					<label for='id_nouveauMDP' class='control-label'>Nouveau mot de passe : </label>
					<input class='form-control' type='password' name='nouveauMDP' id='id_nouveauMDP' placeholder='nouveau mot de passe'>

				</div>

				<div class='form-group'>
					<label for='id_nouveauMDPbis' class='control-label'>Validation du mot de passe : </label>
					<input class='form-control' type='password' name='nouveauMDPbis' id='id_nouveauMDPbis' placeholder='validation du mot de passe'>

				</div>

				<div class='col-xs-6 col-sm-5 col-md-3 clear-both-left'>
					<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
					<?php echo "<input type='hidden' value='{$id}' name='id'>"; ?>
				</div>
			</form>
		</div>



	