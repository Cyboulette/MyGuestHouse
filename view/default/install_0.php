<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
	<?php 
		if(isset($message)) { echo $message; }
	?>
	<div class="alert alert-info text-center">
		Ces quelques pages vont vous permettre d'installer votre CMS, une fois l'installation terminée vous pourrez profiter pleinement du CMS !
	</div>

	<form role="form" action="index.php?step=1" method="POST" autocomplete="off">
		<fieldset>
			<h2>Informations sur votre base de données</h2>
			<div class="alert alert-warning text-center">
				Nous avons besoin de vos informations pour se connecter à votre base de données et de pouvoir y installer le CMS. Tournez-vous vers votre hébergeur pour savoir quelles informations rentrer.
			</div>
			<hr class="colorgraph">

			<div class="form-group">
				<label for="dbname">Nom de la base de données<br/><small>(Le nom de la base de données avec laquelle vous souhaitez utiliser MyGuestHouse)</small></label>
				<input type="text" name="dbname" required id="dbname" value="" class="form-control input-lg" placeholder="Indiquez le nom de votre base de données">
			</div>

			<div class="form-group">
				<label for="uname">Identifiant de la base de données<br/><small>(Nom d'utilisateur MySQL)</small></label>
				<input type="text" name="uname" required id="uname" autocomplete="off" class="form-control input-lg" placeholder="Indiquez le nom d'utilisateur de votre base de données">
			</div>

			<div class="form-group">
				<label for="pwd">Mot de passe de la base de données<br/><small>(Mot de passe MySQL)</small></label>
				<input type="password" name="pwd" id="pwd" autocomplete="new-password" class="form-control input-lg" placeholder="Indiquez le mot de passe de votre base de données">
			</div>

			<div class="form-group">
				<label for="host">Hôte de la base de données<br/><small>(Adresse de l'hôte MySQL)</small></label>
				<input type="text" name="host" required id="host" class="form-control input-lg" placeholder="Indiquez l'hôte de votre base de données">
			</div>

			<hr class="colorgraph">

			<input type="submit" class="btn btn-lg btn-success btn-block" value="Valider">
		</fieldset>
	</form>
</div>