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

	    switch ($rang) {
		    case '3': $rang='Admin'; break;
		    case '2': $rang='Membre'; break;
		    case '1': $rang='Visiteur'; break;
		    default: $rang='Inconnue'; break;
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
						<span class="text-left">Détails sur les reservations</span><span class="text-right"><?=count(ModelReservation::selectAllByUser($id))?> reservation(s) effectuée(s)</span>
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
						<span class="text-left">Détails sur les avis</span><span class="text-right"><?php echo "X"; ?> avi(s) enregistré(s)</span>
					</div>
				</a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			</div>
		</div>
	</div>
</div>

