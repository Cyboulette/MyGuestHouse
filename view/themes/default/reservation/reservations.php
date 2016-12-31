<div>
    <h1 class="page-header">Vos réservations</h1>

    <!-- Navigation for reservation -->
    <div class="col-xs-12 row placeholders">
        <ul class="nav nav-tabs" role="tablist">
            <li <?php ControllerDefault::active('Reservation', 'reservations', 'enattente'); ?> ><a href="index.php?controller=Reservation&action=reservations&mode=enattentes" > En attente <span class="badge">  <?php echo count(ModelReservation::getReservationsEnAttente($_SESSION['idUser'])) ?> </span></a></li>
            <li <?php ControllerDefault::active('Reservation', 'reservations', 'encours'); ?> ><a href="index.php?controller=Reservation&action=reservations&mode=encours" > En cours <span class="badge">  <?php echo count(ModelReservation::getReservationsEnCours($_SESSION['idUser'])) ?> </span></a></li>
            <li <?php ControllerDefault::active('Reservation', 'reservations', 'annulees'); ?> ><a href="index.php?controller=Reservation&action=reservations&mode=annulees" > Annulées <span class="badge">  <?php echo count(ModelReservation::getReservationsAnnulee($_SESSION['idUser'])) ?> </span></a></li>
            <li <?php ControllerDefault::active('Reservation', 'reservations', 'finis'); ?> ><a href="index.php?controller=Reservation&action=reservations&mode=finis" > Finis <span class="badge">  <?php echo count(ModelReservation::getReservationsFinis($_SESSION['idUser'])) ?> </span></a></li>
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
            echo '<th>Actions             </th>';
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
                echo '<td>
                        <a href="index.php?controller=Reservations&action=manageReservation&type=edit&idReservation=' . $id . '" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>
                        <button type="button" class="btn btn-xs btn-danger btnDeleteReservation" data-id="'.$id.'"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer</button>

                        </td>';
                echo '</tr>';


            }
            echo '</table></div>';
            ?>
            <!-- Modal for delete -->
            <div id="deleteReservation" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirmation de suppression</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '<a href="index.php?controller=Chambre&action=readAll" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Consulter nos chambres </a> <br/><br/>';
        ?>

    </div>
</div>
