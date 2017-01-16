<?php if(!$powerNeeded) { exit(); } ?>
<?php if(isset($message)) echo $message; ?>

<?php if(is_null($idChambre)) { ?>

    <!-- Selection de l'id de la chambre -->
    <form role="form" method="POST" action="index.php?controller=reservation&action=reservationChambre">
    <fieldset>
        <h2>Réserver une chambre</h2>
        <hr class="colorgraph">

        <div class="form-group text-center">
            <label for="idChambre">Sélectionnez la chambre que vous souhaitez réserver :</label>
            <select class="form-control" id="idChambre" name="idChambre">
                <?php foreach(ModelChambre::selectAll() as $chambre){
                    echo '<option value="'.strval($chambre->get('idChambre')).'">'.htmlspecialchars($chambre->get('nomChambre')).'</option>';
                } ?>

            </select>
        </div>

        <br>
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
            <input type="submit" class="btn btn-lg btn-success btn-block" value="Selectionner">
        </div>

    </fieldset>
</form>

<?php } else { ?>

    <form id="formforchambre" role="form" method="POST" action="index.php?controller=reservation&action=addReservation">
        <fieldset>
            <h2> Réservation de la chambre n°<?=htmlspecialchars($chambre->get('idChambre'))?> <small>(Prix/nuit = <?=htmlspecialchars($chambre->get('prixChambre'));?> €)</small></h2>
            <div class="alert alert-info">Une date non sélectionnable signifie que la chambre n'est pas disponible</div>
            <hr class="colorgraph">

            <div class="form-group text-center">
                <label for="datepickerDebut"> Choisissez une date de début</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerDebut" class="form-control" type="text" name="dateDebut" value="<?=ControllerDefault::getCurrentDateForDatePicker();?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <div class="form-group text-center">
                <label for="datepickerFin"> Choisissez une date de fin</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerFin" class="form-control" type="text" name="dateFin" value="<?=ControllerDefault::getCurrentDateForDatePicker();?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <input type="hidden" class="prixChambre" value="<?=htmlspecialchars($chambre->get('prixChambre'));?>">
            <input type="hidden" name="idChambre" value="<?=$idChambre?>">
            <?php if(ControllerUtilisateur::isConnected()) { ?>
                <h4 class="text-info text-muted">Vous pourrez ajouter des prestations à votre réservation depuis l'onglet "Réservations"</h4>
            <?php } else { ?>
            <hr class="colorgraph">
            <h2>Prise de contact</h2>
            <div class="alert alert-info">Merci de renseigner vos informations afin que nous puissions prendre contact avec vous si cela était nécessaire</div>
            <div class="form-group text-center">
                <label for="emailV"> Votre adresse e-mail</label>
                <div class="input-group">
                    <input id="emailV" class="form-control" type="email" name="emailV" placeholder="Ex : nom@domaine.fr">
                    <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="form-group text-center">
                <label for="prenomV"> Votre prénom</label>
                <div class="input-group">
                    <input id="prenomV" class="form-control" type="text" name="prenomV" placeholder="Ex : Jean">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="form-group text-center">
                <label for="nomV"> Votre nom</label>
                <div class="input-group">
                    <input id="nomV" class="form-control" type="text" name="nomV" placeholder="Ex : DUPONT">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                </div>
            </div>
            <?php } ?>

            <!-- Module de calcul -->
            <div class="messageCalcul text-center"></div>
            <div class="text-center infoCalcul">
                <h4>Durée : <span class="duree"></span></h4>
                <h4>Prix : <span class="prix"></span></h4>
            </div>

            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                <button class="btn btn-lg btn-success btn-block" id="btnCalcul">Calculer</button>
                <input type="submit" class="btn btn-lg btn-success btn-block" value="Réserver">
            </div>

        </fieldset>
    </form>

<?php } ?>

<!-- Modification du script datePicker pour datesDisabled -->
<?=$sriptDatesExclues?>

