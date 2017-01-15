<?php if(!$powerNeeded) { exit(); } ?> 

  	<h1 class='page-header'><?=$prenom?> <?=$nom?></h1>

		<div class="row">
			<h3>Modification de l'utilisateur </h3>
			<form class="form-horizontal col-xs-offset-1" method='post' action='index.php?controller=adminUtilisateurs&action=edited&idUtilisateur=<?=$id?>' enctype='multipart/form-data'>

				<div class='form-group'>
					<label for='id_email' class='col-sm-2 control-label'>E-mail : </label>
					<div class="col-sm-10">
						<input class='form-control' type='email' name='email' id='id_email' value=<?=$email?>>
					</div>
				</div>

				<div class='form-group'>
					<label for='id_prenom' class='col-sm-2 control-label'>Prenom de l'utilisateur : </label>
					<div class="col-sm-10">
						<input class='form-control' type='text' value=<?=$prenom?> name='prenom' id='id_prenom'>
					</div>
				</div>

				<div class='form-group'>
					<label for='id_nom' class='col-sm-2 control-label'>Nom de l'utilisateur : </label>
					<div class="col-sm-10">
						<input class='form-control' type='text' value=<?=$nom?> name='nom' id='id_nom'>
					</div>
				</div>

				<div class='form-group'>
					<label class="col-sm-2 control-label" for='id_rang'>Rang de l'utilisateur :</label>
					<div class="col-sm-10">
						<select class='form-control' name='rang' id='id_rang'>
							<option value='1' <?=$rang1?>>Visiteur</option>
							<option value='2' <?=$rang2?>>Membre</option>
							<option value='3' <?=$rang3?>>Administrateur</option>
						</select>
					</div>
				</div>


				<div class='form-group'>
					<div class="col-sm-offset-2 col-sm-3">
						<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
						<input type='hidden' value='<?=$id?>' name='id'>
					</div>
				</div>

			</form>
		</div>




		<div class="row">
			<h3>Changement de mot de passe :</h3>

			<form class="form-horizontal col-xs-offset-1" method='post' action='' enctype='multipart/form-data'>

				<div class='form-group'>
					<label for='id_ancienMDP' class="col-sm-2 control-label">Ancien mot de passe : </label>
					<div class="col-sm-10">
						<input class='form-control' type='password' name='ancienMDP' id='id_ancienMDP' placeholder='Ancien mot de passe'>
					</div>
				</div>

				<div class='form-group'>
					<label for='id_nouveauMDP' class="col-sm-2 control-label">Nouveau mot de passe : </label>
					<div class="col-sm-10">
						<input class='form-control' type='password' name='nouveauMDP' id='id_nouveauMDP' placeholder='Nouveau mot de passe'>
					</div>
				</div>

				<div class='form-group'>
					<label for='id_nouveauMDPbis' class="col-sm-2 control-label">Validation du mot de passe : </label>
					<div class="col-sm-10">
						<input class='form-control' type='password' name='nouveauMDPbis' id='id_nouveauMDPbis' placeholder='Validation du mot de passe'>
					</div>
				</div>

				<div class='form-group'>
					<div class="col-sm-offset-2 col-sm-3">
						<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
						<?php echo "<input type='hidden' value='{$id}' name='id'>"; ?>
					</div>
				</div>
			</form>
		</div>



	