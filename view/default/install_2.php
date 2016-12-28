<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
<?php 
	if(isset($message)) { echo $message; } else {
?>
	<div class="alert alert-success text-center">
		Les tables ont bien été crées
	</div>
<?php } ?>

	<form role="form" action="index.php?step=3" method="POST" autocomplete="off">
		<fieldset>
			<h2>Configuration principale du site</h2>
			<div class="alert alert-warning text-center">
				Vous devez maintenant renseigner les principaux paramètres du site afin de pouvoir terminer l'installation
			</div>
			<hr class="colorgraph">

			<div class="form-group">
				<label for="websitename">Nom de votre site<br/><small>(Le nom de votre site est utilisé pour l'affichage, il est changeable depuis le panneau d'administration)</small></label>
				<input type="text" name="websitename" required id="websitename" value="" class="form-control input-lg" placeholder="Indiquez le nom de votre site">
			</div>

			<div class="form-group">
				<label for="email">E-mail du compte administrateur<br/><small>(Ce compte est dans la plupart des cas le votre, sinon il s'agît du compte de l'administrateur principal)</small></label>
				<input type="email" name="email" required id="email" autocomplete="off" class="form-control input-lg" placeholder="Indiquez l'adresse e-mail du compte administrateur">
			</div>

			<div class="form-group">
				<label for="password">Mot de passe de l'administrateur<br/><small>(Mot de passe pour le compte de l'administrateur principal)</small></label>
				<input type="password" name="password" id="password" autocomplete="new-password" class="form-control input-lg" placeholder="Indiquez le mot de passe du compte administrateur">
			</div>

			<div class="form-group">
				<label for="prenom">Prénom de l'administrateur</label>
				<input type="text" name="prenom" required id="prenom" class="form-control input-lg" placeholder="Indiquez le prénom du compte administrateur">
			</div>

			<div class="form-group">
				<label for="nom">Nom de l'administrateur</label>
				<input type="text" name="nom" required id="nom" class="form-control input-lg" placeholder="Indiquez le nom du compte administrateur">
			</div>

			<hr class="colorgraph">
			<input type="hidden" name="forcestep" value="3">
			<input type="submit" class="btn btn-lg btn-success btn-block" value="Valider">
		</fieldset>
	</form>
</div>