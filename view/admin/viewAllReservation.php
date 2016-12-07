<?php if(!$powerNeeded) { exit(); } ?>

<div>
    <h1 class="page-header">Gestion des réservations</h1>

    <div class="col-xs-12 row placeholders">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="index.php?controller=admin&action=displayAllReservation&mode=encours" > En cours <span class="badge">  <?php echo modelReservation::getNombreReservationEnCours() ?> </span></a></li>
            <li><a href="index.php?controller=admin&action=displayAllReservation&mode=enattente" > En attente <span class="badge">  <?php echo modelReservation::getNombreReservationEnAttente() ?> </span></a></li>
            <li><a href="index.php?controller=admin&action=displayAllReservation&mode=finis" > Finis <span class="badge">  <?php echo modelReservation::getNombreReservationFinis() ?> </span></a></li>
            <li><a href="index.php?controller=admin&action=displayAllReservation&mode=annulees" > Annulées <span class="badge">  <?php echo modelReservation::getNombreReservationProbleme() ?> </span></a></li>
        </ul>


        <!-- Navigation for reservation -->
        <?php
        switch($_GET['mode']){
            case 'encours' :    require_once('listReservationEnCours.php'); break;
            case 'enattente':   require_once('listReservationEnAttente.php'); break;
            case 'finis':       require_once('listReservationfinis.php'); break;
            case 'annulees':    require_once('listReservationProbleme.php'); break;
        }
        ?>


    </div>
</div>