<?php
/**
 * This view provide the updating and adding action for reservation
 **/

if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header"><?=$titreAction?></h1>
<?php if(isset($message)) echo $message; ?>

<?php if($type == "add") {
    if(!$_POST['idChambre']){ ?>

        <br>
        <br>
        <form class="form" role="form" method="post" action="index.php?controller=adminReservations&action=manageReservation&type=add">
            <div class="form-group">
                <label for="idChambre"> Selectionnez la chambre </label>
                <select class="form-control" id="idChambre" name="idChambre">
                    <?php foreach(ModelChambre::selectAll() as $chambre) {
                        echo '<option value="'.strval($chambre->get('idChambre')).'">'.htmlspecialchars($chambre->get('nomChambre')).'</option>';
                    } ?>

                </select>
            </div>
            <br>
            <button type="submit" class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 btn btn-success">Selectionner</button>
        </form>
    <?php
        exit();
    } else {
        $idReservation = null;

        $dateDebut = (isset($_POST['dateDebut']) ? htmlspecialchars($_POST['dateDebut']):ControllerDefault::getCurrentDateForDatePicker());
        $dateFin = (isset($_POST['dateFin']) ? htmlspecialchars($_POST['dateFin']):ControllerDefault::getCurrentDateForDatePicker());

        $idUtilisateur = (isset($_POST['idUtilisateur']) ? htmlspecialchars($_POST['idUtilisateur']):'');

        $idChambre = (isset($_POST['idChambre']) ? htmlspecialchars($_POST['idChambre']):'');

        $urlAction = 'index.php?controller=adminReservations&action=addReservation&type=add';
        $titleBouton = 'Ajouter';
    }

} elseif($type == "edit") {
    $idReservation = (isset($_POST['idReservation']) ? htmlspecialchars($_POST['idReservation']):$readReservation->get('idReservation'));

    $dateDebut = (isset($_POST['dateDebut']) ? htmlspecialchars($_POST['dateDebut']):ControllerDefault::getCurrentDateForDatePicker());
    $dateFin = (isset($_POST['dateFin']) ? htmlspecialchars($_POST['dateFin']):ControllerDefault::getCurrentDateForDatePicker());

    $utilisateur = ModelUtilisateur::select($readReservation->get('idUtilisateur'));
    $idUtilisateur = (isset($_POST['idUtilisateur']) ? htmlspecialchars($_POST['idUtilisateur']):$readReservation->get('idUtilisateur'));

    $chambre = ModelUtilisateur::select($readReservation->get('idChambre'));
    $idChambre = (isset($_POST['idChambre']) ? htmlspecialchars($_POST['idChambre']):$readReservation->get('idChambre'));

    $urlAction = 'index.php?controller=adminReservations&action=editReservation&type=edit&idReservation='.$idReservation;
    $titleBouton = 'Modifier';
} ?>
<br>
<br>
<form class="form" role="form" method="POST" action="<?=$urlAction?>" >

    <div class="form-group">
        <label for="idUtilisateur"> Selectionnez le client </label>
        <select class="form-control" name="idUtilisateur" id="idUtilisateur">
            <?php foreach(ModelUtilisateur::selectAll() as $utilisateur){
                echo '<option value="'.strval($utilisateur->get('idUtilisateur')).'">'.$utilisateur->get('nomUtilisateur').'</option>';
            } ?>
        </select>
    </div>

    <?php if($type == "edit") { ?>

    <div class="form-group">
        <label for="idChambre"> Selectionnez la chambre </label>
        <select class="form-control" name="idChambre" id="idChambre">
            <?php foreach(ModelChambre::selectAll() as $chambre){ echo '<option value="'.$chambre->get('idChambre').'">'.$chambre->get('nomChambre').'</option>'; } ?>
        </select>
    </div>

    <?php } ?>

    <br>
    <div class="form-group">
        <label for="dateDebut"> Choisissez une date de début</label>
        <div class="input-group date" data-date-format="yyyy-mm-dd">
            <input id="datepickerDebut" class="form-control" type="text" name="dateDebut" value="<?=$dateDebut;?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        </div>
    </div>

    <br>
    <div class="form-group">
        <label for="dateFin"> Choisissez une date de fin</label>
        <div class="input-group date" data-date-format="yyyy-mm-dd">
            <input id="datepickerFin" class="form-control" type="text" name="dateFin" value="<?=$dateFin;?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        </div>
    </div>

    <br>
    <?php
        if($type == "edit") {
            echo '<input type="hidden" name="idReservation" value="'.$idReservation.'">';
        } else {
            echo '<input type="hidden" name="idChambre" value="'.$idChambre.'">';
        }
    ?>
    <button type="submit" class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 btn btn-success"><?=$titleBouton?></button>
</form>

<!-- Gestion des dates exclues -->
<?=$sriptDatesExclues?>

