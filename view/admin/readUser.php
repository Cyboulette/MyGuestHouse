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

        $avis = ModelAvis::selecCustomAvis('idUtilisateur', $idUtilisateur);
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

        $listeChambreForAvis = ModelAvis::listeChambresPourAvis($idUtilisateur);
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
						<span class="text-left">Détails sur les avis</span><span class="text-right"><?= $nbAvis?> avis enregistré<?=$SOfAvis?></span>
					</div>
				</a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body">
				<?php 
					if(!empty($listeChambreForAvis)){
						echo "<pre>";
							print_r($listeChambreForAvis);
						echo "</pre>";

						foreach ($listeChambreForAvis as $value) {
							echo $value[0];
						}

					}else{
						echo "string";
					}
				?>

				<?php 
					if($nbAvis != 0){
				?>
						<div class="row border-avis">
							<div class='descriptionChambre'>  
					            <ul> 
					                <li class="no-puce"> 
					                 	Nom de la chambre : nom
					                </li> 
					                <li class="no-puce"> 
					                 	Note : <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i> 
					                </li> 
					                <li class="no-puce"> 
					                	Avis : 
					                	<ul> 
					                		<li class="no-puce border"> 
					                			ljbviuebiv eiubvedv izuhochi zaoihnvihe iub vhzb ihj ouzb ihbouih oub i hb  b sjd hxid s 
					                		</li> 
					               		</ul> 
					                </li> 
					            </ul> 
					            <a href='#' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>
					            <a href='#' class='btn btn-xs btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i> Supprimer</a>
				            </div>
						</div>

						<div class="row border-avis">
							<form class="form-horizontal" method="post" action="index.php?controller=adminChambres&action=editedChambre">
								<div class="form-group">
								    <label for="id_nom" class="col-xs-2 control-label">Nom de la chambre :</label>
								    <div class="col-xs-10">
								      <input type="text" class="form-control" value="nom" name="nom" id="id_nom">
								    </div>
								</div>

								<div class="form-group">
								    <label for="id_superficie" class="col-xs-2 control-label">Note :</label>
								    <div class="col-xs-10">
								      <input type="number" min="0" max="5" class="form-control" value="superficie" name="superficie" id="id_superficie">
								    </div>
								</div>

								<div class="form-group">
								    <label for="desc_chambre" class="col-xs-2 control-label">Avis :</label>
								    <div class="col-xs-10">
								      <textarea id="desc_chambre" name="description" class="form-control"><?=$description?></textarea>
								    </div>
								</div>

								<div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">
								      <input type="submit" class="btn btn-success" value="Ajouter">
								      <input type="hidden" name="id" value="123">
								    </div>
								</div>
							</form>
						</div>
				<?php 
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

