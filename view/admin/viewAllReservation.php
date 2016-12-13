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



        <!-- IN PROGRESS -->

        <?php if(!$powerNeeded) { exit(); }
        elseif(empty($tab_reservations)) {
            echo '<div class="alert alert-danger">Vous ne disposez d\'aucune réservation pour le moment</div>';
        } else {
            echo '<div class="table-responsive"><table class="table table-hover tableCenter">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID                  </th>';
            echo '<th>Nom                 </th>';
            echo '<th>Prénom              </th>';
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
                $nomchambre = $reservations->getNomChambre();
                $duree = $reservations->getNombreJours();
                $prix = $reservations->getPrixTotal();
                $nbPrestations = count(ModelPrestation::selectAllByChambre($reservations->get('idChambre')));
                //$nbPrestations = count(ModelChambre::selectPrestation($id));
                echo '<tr>';
                echo '<td>' . $id .                 '</td>';
                echo '<td>' . $nom .                '</td>';
                echo '<td>' . $prenom .             '</td>';
                echo '<td>' . $nomchambre .         '</td>';
                echo '<td>' . $duree .              '</td>';
                echo '<td>' . $prix . ' €            </td>';
                echo '<td><a href="index.php?controller=admin&action=managePrestations&idChambre=' . $id . '" class="btn btn-xs btn-primary">' . $nbPrestations . ' <i class="fa fa-cog" aria-hidden="true"></i></a></td>';
                echo '<td>
                        <a href="index.php?controller=admin&action=editChambre&idChambre=' . $id . '" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteChambre" onclick="GETurl(id, ' . $id . ')">Supprimer</button>

                        </td>';
                echo '</tr>';


            }
            echo '</table></div>';
        }
        ?>


    </div>
</div>
