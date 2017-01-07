<!-- On attends
        * la liste des chambres
        * les dates des réservations effectuées pour les afficher

-->

<?php 
    if(isset($_GET['idChambre'])) {
        $idChambre = htmlspecialchars($_GET['idChambre']);
    } else if(isset($_POST['idChambre'])) {
        $idChambre = htmlspecialchars($_POST['idChambre']);
    } else {
        $idChambre = null;
    }
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
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
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
                <div class="input-group date" data-date-format="mm-dd-yyyy">
                    <input id="datepickerDebut" class="form-control" type="text" name="dateDebut" value="01/01/2017">
                    <span class="input-group-addon"><a href="#"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
            </div>

            <br>
            <div class="form-group text-center">
                <label for="dateFin"> Choisissez une date de fin</label>
                <div class="input-group date" data-date-format="mm-dd-yyyy">
                    <input id="datepickerFin" class="form-control" type="text" name="dateFin" value="01/01/2017">
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

