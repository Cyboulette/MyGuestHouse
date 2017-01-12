<!-- Todo : calculator module -->

<?php if(isset($message)) echo $message; ?>

<?php if(is_null($idChambre)) { ?>

    <!-- Selection de l'id de la chambre -->
    <form role="form" method="POST" action="index.php?controller=reservation&action=reservationChambre">
    <fieldset>
        <h2> Réserver un chambre </h2>
        <hr class="colorgraph">

        <div class="form-group text-center">
            <label for="idChambre">Sélectionnez la chambre que vous souhaitez réserver :</label>
            <select class="form-control" id="idChambre" name="idChambre">
                <?php foreach(ModelChambre::selectAll() as $chambre){
                    echo '<option value="'.strval($chambre->get('idChambre')).'">'.$chambre->get('nomChambre').'</option>';
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
            <h2> Réservation de la chambre n°<?=$_POST['idChambre'] + $_GET['idChambre']?></h2>
            <hr class="colorgraph">

            <br>
            <div class="form-group text-center">
                <label for="dateDebut"> Choisissez une date de début</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerDebut" class="form-control" type="text" name="dateDebut" value="<?=ControllerDefault::getCurrentDateForDatePicker();?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <br>
            <div class="form-group text-center">
                <label for="dateFin"> Choisissez une date de fin</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerFin" class="form-control" type="text" name="dateFin" value="<?=ControllerDefault::getCurrentDateForDatePicker();?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <input type="hidden" name="idChambre" value="<?=$idChambre?>">

            <!-- Module de calcul -->
            <br>
            <div class="text-center">
                <h4>Durée : </h4>
                    <script>
                        $("btnCalcul").onclick(function(){
                            var dateDebut = new Date($('#datepickerDebut', 'value'));
                            var dateFin = new Date($('#datepickerFin', 'value'));
                            var timediff = dateFin - dateDebut;
                            print(Math.floor(timediff / day));
                        });
                    </script>
                <h4>Prix : </h4>
            </div>

            <br>
            <br>
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                <button class="btn btn-lg btn-success btn-block" id="btnCalcul">Calculer</button>
                <input type="submit" class="btn btn-lg btn-success btn-block" value="Réserver">
            </div>
        </fieldset>
    </form>

<?php } ?>







<!-- Modification du script datePicker pour datesDisabled -->
<?=$sriptDatesExclues?>

