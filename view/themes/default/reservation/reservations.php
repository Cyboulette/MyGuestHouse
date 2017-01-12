<?php if(isset($message)) echo $message; ?>

<div>
    <h1 class="page-header">Vos réservations</h1>

    <!-- Navigation for reservation -->
    <div class="col-xs-12 row placeholders">
        <ul class="nav nav-tabs" role="tablist">
            <li <?php ControllerDefault::active('reservation', '', 'enattentes'); ?> ><a href="index.php?controller=reservation&action=reservations&mode=enattentes" > En attente <span class="badge">  <?php echo count(ModelReservation::getReservationsEnAttente($_SESSION['idUser'])) ?> </span></a></li>
            <li <?php ControllerDefault::active('reservation', '', 'encours'); ?> ><a href="index.php?controller=reservation&action=reservations&mode=encours" > En cours <span class="badge">  <?php echo count(ModelReservation::getReservationsEnCours($_SESSION['idUser'])) ?> </span></a></li>
            <li <?php ControllerDefault::active('reservation', '', 'annulees'); ?> ><a href="index.php?controller=reservation&action=reservations&mode=annulees" > Annulées <span class="badge">  <?php echo count(ModelReservation::getReservationsAnnulee($_SESSION['idUser'])) ?> </span></a></li>
            <li <?php ControllerDefault::active('reservation', '', 'finis'); ?> ><a href="index.php?controller=reservation&action=reservations&mode=finis" > Finies <span class="badge">  <?php echo count(ModelReservation::getReservationsFinis($_SESSION['idUser'])) ?> </span></a></li>
        </ul>
        <br>

        <?php
        if(empty($tab_reservations)) {
            echo '<div class="alert alert-danger">Vous ne disposez d\'aucune réservation pour le moment</div>';
        } else {
            echo '<div class="table-responsive"><table class="table table-hover tableCenter">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nom de la chambre   </th>';
            echo '<th>Durée               </th>';
            echo '<th>Prix                </th>';
            echo '<th>Prestations         </th>';
            echo '</tr>';
            echo '</thead>';
            foreach ($tab_reservations as $reservations) {
                $id = $reservations->get('idReservation');
                $utilisateur = ModelUtilisateur::select($reservations->get('idUtilisateur'));
                $nom = $utilisateur->get('nomUtilisateur');
                $prenom = $utilisateur->get('prenomUtilisateur');
                $chambre = ModelChambre::select($reservations->get('idChambre'));
                $idChambre = $chambre->get('idChambre');
                $nomchambre = $chambre->get('nomChambre');
                $nbPrestations = count(ModelPrestation::selectAllByReservation($reservations->get('idReservation')));

                $prix = $reservations->getPrixTotal();
                $duree = $reservations->getNombreJours();

                echo '<tr>';
                echo '<td>' . $nomchambre .         '</td>';
                echo '<td>' . $duree .              '</td>';
                echo '<td>' . $prix . ' €            </td>';
                echo '<td><a href="index.php?controller=Reservations&action=managePrestationForReservation&idReservation='.$id.'" class="btn btn-xs btn-primary">'.$nbPrestations.' <i class="fa fa-cog" aria-hidden="true"></i></a></td>';
                echo '</tr>';


            }
            echo '</table></div>';
            ?>
            <?php
        }
        ?>

        <a href="index.php?controller=Chambre&action=readAll" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Consulter nos chambres </a>
        <a href="index.php?controller=reservation&action=reservationChambre" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Faite une reservation </a>
    </div>
</div>
