<?php if(!$powerNeeded) { exit(); } ?>

<?php 
    if(!isset($utilisateur)){
        exit();
    }else{
    	$idUtilisateur = $utilisateur->get('idUtilisateur');
        $nom = $utilisateur->get('nomUtilisateur');
        $prenom = $utilisateur->get('prenomUtilisateur');
        $email = $utilisateur->get('emailUtilisateur');

        $avis = ModelAvis::selectCustomAvis('idUtilisateur', $idUtilisateur);
        $nbAvis = ModelAvis::countCustomAvis('idUtilisateur', $idUtilisateur);
        if($nbAvis>1){
        	$SOfAvis = 's';
        }else{
        	$SOfAvis =	'';
        }
        $listeChambreForAvis = ModelAvis::listeChambresPourAvis($idUtilisateur);

        $nbReservation = count(ModelReservation::selectAllByUser($idUtilisateur));
        if($reservation>1){
        	$SOfReservation = 's';
        }else{
        	$SOfReservation =	'';
        }
    }
?>

<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2"> 
	<h1 class="page-header"> Bonjour <?php echo $prenom.' '.$nom;?></h1>
	<?php if(isset($message)) echo $message; ?>

	<div class="row col-lg-offset-0">
		<div class="row">
			<div class=" col-lg-12">
				<div class="col-sm-3">
					<span class="fa-stack fa-5x">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-users fa-inverse fa-stack-1x"></i>
					</span>
				</div>
				<div class=" col-sm-9">
					<div class="col-md-12">
						<h4>Prenom : <?=$prenom?> 
					</div>
					<div class="col-md-12">
						<h4>Prenom : <?=$nom?> 
					</div>
					<div class="col-md-12">
						<h4>Mail : <?=$email?></h4>
					</div>
					
				 </div>
			</div>
		</div>
		<div class='row'>
			<div class="col-lg-12 col-lg-offset-0">
				<a href="index.php?controller=utilisateur&action=edit" class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>
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
					?>	
							<div class="row border-avis margin-bottom-30px">
								<h2 class='text-center'>Ajouter un avis a nos chambres</h2>
								<form class="form-horizontal" method="post" action="index.php?controller=avis&action=add">
									<div class="form-group">
										<label for="id_chambre" class="col-xs-3 control-label text-left">Nom de la chambre :</label>
									    <select class="form-control col-xs-10" name='idChambre' id='id_chambre'>
											<?php
												foreach ($listeChambreForAvis as $key => $value) {
													$idChambre = $value[0];
													$chambre = ModelChambre::select($idChambre);
													if($chambre!=false){
														if($key==0){
															$select="selected='selected'";
														}else{
															$select="";
														}
														$nomChambre = $chambre->get('nomChambre');
											?>
														<option value=<?=$idChambre?> <?=$select?> ><?=$nomChambre?></option>
											<?php
													}
												}
											?>
										</select>
									</div>

									<div class="form-group row">
									    <label for="id_note" class="col-xs-2 control-label">Note :</label>
									    <div class="col-xs-10">
									      <input type="number" min="0" max="5" class="form-control" placeholder='0..5' name="note" id="id_note">
									    </div>
									</div>

									<div class="form-group row">
									    <label for="id_avis" class="col-xs-2 control-label">Avis :</label>
									    <div class="col-xs-10">
									      <textarea id="id_avis" name="avis" placeholder='Votre avis sur la chambre !' class="form-control"></textarea>
									    </div>
									</div>

									<div class="form-group row">
									    <div class="col-sm-offset-2 col-sm-10">
									      <input type="submit" class="btn btn-success" value="Ajouter">
									      <input type="hidden" name="idUtilisateur" value=<?=$idUtilisateur?>>
									    </div>
									</div>
								</form>
							</div>

					<?php
						}
					?>

					<?php 
						if($nbAvis != 0){
							foreach ($avis as $key => $value) {
								$note = $value->get('note');
								$commentaire = nl2br($value->get('commentaire'));
								$idUtilisateur = $value->get('idUtilisateur');
								$idChambre = $value->get('idChambre');

								$nomChambre = (ModelChambre::select($idChambre))->get('nomChambre');
								// echo "<pre>";
								// 	var_dump($value);
								// echo "</pre>";
								// echo "<pre>";
								// 	var_dump($avis);
								// echo "</pre>";
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
							            <?php echo "<a href='?controller=avis&action=edit&idUtilisateur={$idUtilisateur}&idChambre={$idChambre}' class='btn btn-xs btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Modifier</a>" ?>
							            <?php echo "<a href='?controller=avis&action=delete&idUtilisateur={$idUtilisateur}&idChambre={$idChambre}' class='btn btn-xs btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i> supprimer</a>" ?>
						            </div>
								</div>


					<?php
								// echo "<pre>";
								// 	print_r($value);
								// echo "<pre>";
							}
						// echo $avis;
						// echo "<pre>";
						// 	print_r($avis);
						// echo "<pre>";
						}else{
					?>
							<div class="alert alert-danger">Vous n'avez pas encore emis d'avis !</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>