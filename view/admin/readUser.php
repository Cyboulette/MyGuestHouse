<?php if(!$powerNeeded) { exit(); } ?>

<?php 
    if(!isset($utilisateur)){
        exit();
    }else{
    	$idUtilisateur = $utilisateur->get('idUtilisateur');
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
        }else{
        	$SOfAvis =	'';
        }

        $nbReservation = count(ModelReservation::selectAllByUser($id));
        if($reservation>1){
        	$SOfReservation = 's';
        }else{
        	$SOfReservation =	'';
        }
    }
?>

<h1 class="page-header"><?php echo $prenom.' '.$nom;?></h1>
<?php if(isset($message)) echo $message; ?>

<div class="row col-lg-offset-0">
	<div class="row">
		<div class="col-lg-6">
			<div class="col-lg-4">
				<span class="fa-stack fa-5x">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-users fa-inverse fa-stack-1x"></i>
				</span>
			</div>
			<div class="col-lg-8">
				<div class="col-md-12">
					<h4><?php echo $email; ?></h4>
				</div>
				<div class="col-md-12">
					<h4><?php echo $rang.' / '.$statut; ?></h4>
				</div>
			 </div>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-12 col-lg-offset-0">
			<?php echo "<a href='index.php?controller=adminUtilisateurs&action=contact&idUtilisateur=ABC' class='btn btn-xs btn-warning'><i class='fa fa-envelope' aria-hidden='true'></i> Contacter</a>"; ?>
			<?php echo "<a href='index.php?controller=adminUtilisateurs&action=edit&idUtilisateur={$id}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>"; ?>
			<button type="button" class="btn btn-xs btn-danger btnDeleteUser" data-toggle="modal" data-target="#deleteUser"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button><!-- TODO -->
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
						<span class="text-left">Détails sur les reservations</span><span class="text-right"><?= $nbReservation?> reservation<?=$SOfReservation?> effectuée<?=$SOfReservation?></span>
					</div>
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
				Argent perdu : <?=ModelReservation::selectAllPrixByUser($id)?> € <!-- j'ai pas compris pourquoi 'argent perdu' ??? -->
				<br>
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

							$nomChambre = (ModelChambre::select($idChambre))->get('nomChambre');
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
							        <?php echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i> supprimer</a>" ?>
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

