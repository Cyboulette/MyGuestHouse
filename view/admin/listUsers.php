<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header">Liste des utilisateurs</h1>

<?php
if(isset($message)) { echo $message; }

$nbAll=ModelUtilisateur::count();
$nbAdmin=ModelUtilisateur::countSelectByRang('3');
$nbMembre=ModelUtilisateur::countSelectByRang('2');
$nbVisiteur=ModelUtilisateur::countSelectByRang('1');
$nbVisiteur=ModelUtilisateur::countSelectByRang('1');
$nbNonConfirme=ModelUtilisateur::countSelectNonValide();
?>


<a href="index.php?controller=adminUtilisateurs&action=add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un utilisateur</a><br/><br/>

<ul class='nav nav-tabs' role='tablist'>
	<li <?php ControllerDefault::active('adminUtilisateurs', '', 'all'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=all' > Tout <span class='badge'>  <?php echo $nbAll; ?> </span></a></li>
	<li <?php ControllerDefault::active('adminUtilisateurs', '', 'admin'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=admin' > Admin <span class='badge'>  <?php echo $nbAdmin; ?> </span></a></li>
	<li <?php ControllerDefault::active('adminUtilisateurs', '', 'membre'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=membre' > Membre <span class='badge'>  <?php echo $nbMembre; ?> </span></a></li>
	<li <?php ControllerDefault::active('adminUtilisateurs', '', 'visiteur'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=visiteur' > Visiteur <span class='badge'>  <?php echo $nbVisiteur; ?> </span></a></li>
	<li <?php ControllerDefault::active('adminUtilisateurs', '', 'nonValide'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=nonValide' > Non Validé <span class='badge'>  <?php echo $nbNonConfirme; ?> </span></a></li>
</ul>
<br>

<?php
if(empty($tab_utilisateurs)){
	echo '<div class="alert alert-danger">Vous ne disposez d\'aucun utilisateur dans cette catégorie pour le moment !</div>';
}else{
	echo '<div class="table-responsive"><table class="table table-hover tableCenter">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Valide</th>';
	echo '<th>Prenom</th>';
	echo '<th>Nom</th>';
	echo '<th>Login</th>';
	echo '<th>Statut</th>';
	echo '<th>Actions</th>';
	echo '</tr>';
	echo '</thead>';
	foreach ($tab_utilisateurs as $utilisateur) {
		$id = htmlspecialchars($utilisateur->get('idUtilisateur'));
		$nom = htmlspecialchars($utilisateur->get('nomUtilisateur'));
		$prenom = htmlspecialchars($utilisateur->get('prenomUtilisateur'));
		$email = htmlspecialchars($utilisateur->get('emailUtilisateur'));
		$login = htmlspecialchars($utilisateur->get('emailUtilisateur'));
		$statut = htmlspecialchars($utilisateur->get('rang'));
		$valide = htmlspecialchars($utilisateur->get('nonce'));

		if($statut == '3'){
			$statut = 'Admin';
		}else if($statut == '2'){
			$statut = 'Membre';
		}else if($statut == '1'){
			$statut = 'Visiteur';
		}

		if($valide != null){
			$valide = 'NON';
		}else{
			$valide = 'OUI';
		}

		
        	echo '<tr>';
				echo '<td>'.$valide.'</td>';
				echo '<td>'.$prenom.'</td>';
				echo '<td>'.$nom.'</td>';
				echo '<td>'.$login.'</td>';
				echo '<td>'.$statut.'</td>';

		if( $id != $_SESSION['idUser']){
			echo "<td>
					<a href='index.php?controller=adminUtilisateurs&action=read&idUtilisateur={$id}' class='btn btn-xs btn-primary'><i class='fa fa-eye' aria-hidden='true'></i> Voir le profil</a>

					<a href='mailto:{$email}' class='btn btn-xs btn-warning'><i class='fa fa-envelope' aria-hidden='true'></i> Contacter</a>

					<a href='index.php?controller=adminUtilisateurs&action=edit&idUtilisateur={$id}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>

					<button type='button' class='btn btn-xs btn-danger btnDelete' data-url='adminUtilisateurs' data-id={$id}><i class='fa fa-trash-o' aria-hidden='true'></i> Supprimer</button>
				</td>";
			echo '</tr>';
        }else{
        	echo "<td>
					<a href='index.php?controller=adminUtilisateurs&action=read&idUtilisateur={$id}' class='btn btn-xs btn-primary'><i class='fa fa-eye' aria-hidden='true'></i> Voir le profil</a>

					<a href='index.php?controller=adminUtilisateurs&action=edit&idUtilisateur={$id}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>
				</td>";
			echo '</tr>';
        }	
	}

	echo '</table></div>';
}
?>
<!-- BOOTSTRAP MODAL -->

<div id="deleteItem" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirmation de suppression</h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>



