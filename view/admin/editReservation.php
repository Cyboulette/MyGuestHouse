<!-- IN PROGRESS -->
<?php if(!$powerNeeded) { exit(); } ?>

<?php
// variables
$id = $reservation->get('idReservation');
$utilisateur = ModelUtilisateur::select($reservation->get('idUtilisateur'));
$nom = $utilisateur->get('nomUtilisateur');
$prenom = $utilisateur->get('prenomUtilisateur');
$nomchambre = $reservation->getNomChambre();
$duree = $reservation->getNombreJours();
$prix = $reservation->getPrixTotal();
$nbPrestations = count(ModelPrestation::selectAllByChambre($reservation->get('idChambre')));

echo "<h1 class='page-header'>{$nom}</h1>";
echo "
		<form method='post' action='index.php?controller=admin&action=editedReservation' enctype='multipart/form-data'>

			<div class='form-group row'>
				<label for='id_nom' class='col-xs-3 col-form-label'>Id de la reservation : </label>
				<div class='col-xs-3'>
					<input type='text' value='{$id}' name='nomReservation' id='id_nom'>
				</div>
			</div>

			<div class='form-group row'>
				<label for='id_prix' class='col-xs-3 col-form-label'>Prix : </label>
				<div class='col-xs-3'>
					<input type='number' min='0' value='{$prix}' name='prix' id='id_prix'>&euro;
				</div>
			</div>

			<div class='form-group row'>
				<label for='id_prix' class='col-xs-3 col-form-label'>Prix : </label>
				<div class='col-xs-3'>
					<input type='number' min='0' value='{$prix}' name='prix' id='id_prix'>&euro;
				</div>
			</div>

			<div class='col-xs-6 col-sm-5 col-md-2'>
				<input type='submit' class='btn btn-s btn-success btn-block' value='Modifier'>
				<input type='hidden' value='{$id}' name='idReservation'/>
			</div>
		</form>

		<div class='col-xs-6 col-sm-5 col-md-2'>
			<a href='?controller=admin&action=reservations' class='btn btn-s btn-danger btn-block'>Annuler</a>
		</div>
	";

?>