<?php if(!$powerNeeded) { exit(); } ?>

<div>
    <h1 class="page-header">Gestion des réservations</h1>

    <!-- Navigation for reservation -->
    <div class="col-xs-12 row placeholders">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="index.php?controller=admin&action=reservations&mode=encours" > En cours <span class="badge">  <?php echo count(ModelReservation::getReservationsEnCours()) ?> </span></a></li>
            <li><a href="index.php?controller=admin&action=reservations&mode=enattente" > En attente <span class="badge">  <?php echo count(ModelReservation::getReservationsEnAttente()) ?> </span></a></li>
            <li><a href="index.php?controller=admin&action=reservations&mode=finis" > Finis <span class="badge">  <?php echo count(ModelReservation::getReservationsFinis()) ?> </span></a></li>
            <li><a href="index.php?controller=admin&action=reservations&mode=annulees" > Annulées <span class="badge">  <?php echo count(ModelReservation::getReservationsAnnulee()) ?> </span></a></li>
        </ul>



        <?php
        switch($_GET['mode']){
            case 'encours' :    require_once('listReservationEnCours.php'); break;
            case 'enattente':   require_once('listReservationEnAttente.php'); break;
            case 'finis':       require_once('listReservationFinis.php'); break;
            case 'annulees':    require_once('listReservationProbleme.php'); break;
        }
        ?>


    </div>
</div>
