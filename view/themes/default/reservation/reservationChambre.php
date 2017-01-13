<!-- Todo : calculator module -->
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
            <h2> Réservation de la chambre n°<?=htmlspecialchars($chambre->get('idChambre'))?></h2>
            <hr class="colorgraph">

            <div class="form-group text-center">
                <label for="dateDebut"> Choisissez une date de début</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerDebut" class="form-control" type="text" name="dateDebut" value="<?=ControllerDefault::getCurrentDateForDatePicker();?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <div class="form-group text-center">
                <label for="dateFin"> Choisissez une date de fin</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerFin" class="form-control" type="text" name="dateFin" value="<?=ControllerDefault::getCurrentDateForDatePicker();?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <input type="hidden" class="prixChambre" value="<?=htmlspecialchars($chambre->get('prixChambre'));?>">
            <input type="hidden" name="idChambre" value="<?=$idChambre?>">

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

