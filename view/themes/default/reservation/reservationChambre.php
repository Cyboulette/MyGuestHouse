<!-- On attends
        * la liste des chambres
        * les dates des réservations effectuées pour les afficher

-->

<?php 

?>

<?php if(is_null($idChambre)) { ?>

    <!-- Selection de l'id de la chambre -->
    <form role="form" method="POST" action="index.php?controller=reservation&action=reservationChambre">
    <fieldset>
        <h2> Réserver un chambre </h2>
        <hr class="colorgraph">

        <div class="form-group text-center">
            <label for="idChambre">Sélectionnez la chambre que vous souhaitez réserver :</label>
            <select class="form-control" id="idChambre" name="idChambre">
                <?php foreach(ModelChambre::selectAll() as $chambre){ echo '<option>'.$chambre->get('idChambre').'</option>'; } ?>

            </select>
        </div>

        <br>
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
            <input type="submit" class="btn btn-lg btn-success btn-block" value="Selectionner">
        </div>

    </fieldset>
</form>

<?php } else { ?>

    <form id="formforchambre" role="form" action="index.php?controller=reservation&action=reserve">
        <fieldset>
            <h2> Chambre n°<?=$_POST['idChambre'] + $_GET['idChambre']?></h2>
            <hr class="colorgraph">

            <br>
            <div class="form-group text-center">
                <label for="dateDebut"> Choisissez une date de début</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerDebut" class="form-control" type="text" name="dateDebut" value="2017-01-01">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

            <br>
            <div class="form-group text-center">
                <label for="dateFin"> Choisissez une date de fin</label>
                <div class="input-group date" data-date-format="yyyy-mm-dd">
                    <input id="datepickerFin" class="form-control" type="text" name="dateFin" value="2017-01-01">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>


            <br>
            <br>
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                <input type="submit" class="btn btn-lg btn-success btn-block" value="Réserver">
            </div>
        </fieldset>
    </form>

<?php } ?>


