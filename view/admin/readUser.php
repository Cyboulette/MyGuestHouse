<?php if(!$powerNeeded) { exit(); } ?>

<?php 
    if(!isset($utilisateur)){
        exit();
    } else {
    	$idUtilisateur = htmlspecialchars($utilisateur->get('idUtilisateur'));
        $nom = htmlspecialchars($utilisateur->get('nomUtilisateur'));
        $prenom = htmlspecialchars($utilisateur->get('prenomUtilisateur'));
        $email = htmlspecialchars($utilisateur->get('emailUtilisateur'));
	    $rang = htmlspecialchars($utilisateur->get('rang'));
	    $statut = htmlspecialchars($utilisateur->get('nonce'));

	    if($statut != null){
	    	$statut = 'Non activé';
	    } else {
	    	$statut = 'Activé';
	    }

	    switch ($rang) {
		    case '3': $rang='Admin'; break;
		    case '2': $rang='Membre'; break;
		    case '1': $rang='Visiteur'; break;
		    default: $rang='Inconnue'; break;
        }

        $avis = ModelAvis::selectCustomAvis('idUtilisateur', $idUtilisateur);
        $nbAvis = ModelAvis::countCustomAvis('idUtilisateur', $idUtilisateur);
        if($nbAvis>1){
        	$SOfAvis = 's';
        } else {
        	$SOfAvis =	'';
        }

        $nbReservation = count(ModelReservation::selectAllByUser($idUtilisateur));
        if($nbReservation>1){
        	$SOfReservation = 's';
        } else {
        	$SOfReservation =	'';
        }

        if($idUtilisateur == $_SESSION['idUser']){
        	$oneself = true;
        } else {
        	$oneself = false;
        }
		if(count($reservationsEnCours) > 1) {
			$SForReservationEnCours = 's';
		} else {
			$SForReservationEnCours = '';
		}
		if(count($reservationsEnAttente) > 1) {
			$SForReservationEnAttente = 's';
		} else {
			$SForReservationEnAttente = '';
		}
		if(count($reservationsFinies) > 1) {
			$SForReservationFini = 's';
		} else {
			$SForReservationFini = '';
		}
		if(count($reservationsAnnulees) > 1) {
			$SForReservationAnnulee = 's';
		}else {
			$SForReservationAnnulee = '';
		}
    }
?>

<h1 class="page-header text-xs-center"><?php echo $prenom.' '.$nom;?></h1>
<?php if(isset($message)) echo $message; ?>

<!-- haut de la page avec email et rang-->
<div class="row col-sm-offset-0 col-xs-offset-4">
	<div class="row">
		<div class="col-lg-6">
			<div class="col-lg-4">
				<span class="fa-stack fa-5x">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-users fa-inverse fa-stack-1x"></i>
				</span>
			</div>
			<div class="col-lg-8">
				<?php  
					if(!$oneself){
				?>	
						<div class="col-md-12">
							<h4><?php echo $email; ?></h4>
						</div>
						<div class="col-md-12">
							<h4><?php echo $rang.' / '.$statut; ?></h4>
						</div>
				<?php  
					}else{
				?>
						<div class="col-md-12">
						<h4>Prénom : <?=$prenom?></h4>  
						</div>
						<div class="col-md-12">
							<h4>Nom : <?=$nom?></h4>  
						</div>
						<div class="col-md-12">
							<h4>Mail : <?=$email?></h4>
						</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-12">
			<?php 
				if(!$oneself){ 
					echo "<a href='mailto:{$email}' class='btn btn-xs btn-warning'><i class='fa fa-envelope' aria-hidden='true'></i> Contacter</a>";
				}
			?>
			<?php echo "<a href='index.php?controller=adminUtilisateurs&action=edit&idUtilisateur={$idUtilisateur}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>"; ?>
			<?php 
				if(!$oneself){ 
			?>
					<button type="button" class="btn btn-xs btn-danger btnDelete" data-url="adminUtilisateurs" data-id="<?=$idUtilisateur?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>
			<?php  
				}
			?>
		</div>
	</div>
</div>

</br>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<div class="space-for-according">
						<span class="text-left">Détails sur les réservations</span><span class="text-right"><?= $nbReservation?> reservation<?=$SOfReservation?> effectuée<?=$SOfReservation?> au total</span>
					</div>
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">

				<?php if ($tab_reservations != null) { ?>

					<ul class="no-puce">
						<li>Récapitulatif du client :</li>
						<ul class="no-puce">
							<li><?=count($reservationsEnCours)?> réservation<?=$SForReservationEnCours?> en cours.</li>
							<li><?=count($reservationsEnAttente)?> réservation<?=$SForReservationEnAttente?> en attente.</li>
							<li><?=count($reservationsFinies)?> réservation<?=$SForReservationFini?> finie<?=$SForReservationFini?>.</li>
							<li class="text-danger"><?=count($reservationsAnnulees)?> réservation<?=$SForReservationAnnulee?> annulée<?=$SForReservationAnnulee?>.</li>
						</ul>
					</ul>
					<ul class="no-puce">
						<li>Dernière réservation : du <?=ControllerDefault::getLastObject(ModelReservation::selectAllByUser($idUtilisateur))->get('dateDebut')?> au <?=ControllerDefault::getLastObject(ModelReservation::selectAllByUser($idUtilisateur))->get('dateFin')?></li>
					</ul>
					<ul class="no-puce">
						<li class="text-success">Argent dépensé : <?=$argentDepense?> €</li>
					</ul>

				<?php } else { ?>
					<div class="container">
						<ul class="no-puce">
							<li class="text-danger">Ce client n'a réservé aucune chambre ! </li>
						</ul>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingTwo">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					<div class="space-for-according">
						<span class="text-left">Détails sur les avis</span><span class="text-right"><?=$nbAvis?> avis enregistré<?=$SOfAvis?></span>
					</div>
				</a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body">
				<?php 
					if($nbAvis != 0){
						foreach ($avis as $key => $value) {
							$note = $value->get('note');
							$commentaire = nl2br($value->get('commentaire'));
							$idUtilisateur = $value->get('idUtilisateur');
							$idChambre = $value->get('idChambre');

							$nomChambre = ModelChambre::select($idChambre)->get('nomChambre');
				?>
							<div class="row border-avis">
								<div class='descriptionChambre'>  
						            <ul> 
						                <li class="no-puce"> 
						                 	Nom de la chambre : <?=$nomChambre?>
						                </li> 
						                <li class="no-puce"> 
						                 	Note : 
						                 	<?php  
						                 		if( is_numeric($note) && $note>=0 && $note<=5){
						                 			for ($i=0; $i<$note ; $i++) { 
						                 	?>
						                 				<i class="fa fa-star" aria-hidden="true"></i>
						                 	<?php			
						                 			}
						                 			for ($i=0; $i < (5-$note) ; $i++) { 
						                 	?>
						                 				<i class="fa fa-star-o" aria-hidden="true"></i>
						                 	<?php
						                 			}
							                 	}
						                 	?>
							                <small>(<?=$note?>/5)</small>
							            </li> 
							            <li class="no-puce"> 
							                Avis : 
							                <ul> 
							                	<li class="no-puce border"><?=$commentaire?></li> 
							              	</ul> 
							            </li> 
							        </ul> 
							        <?php echo "<a href='#' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>" ?>
							        <?php echo "<a href='?controller=AdminAvis&action=delete&idUtilisateur={$idUtilisateur}&idChambre={$idChambre}' class='btn btn-xs btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i> Supprimer</a>" ?>
						        </div>
							</div>
				<?php
						}
					}else{
				?>
						<div class="alert alert-danger">Cet utilisateur n'a pas encore emis d'avis !</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>

<!-- Delete modal-->
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