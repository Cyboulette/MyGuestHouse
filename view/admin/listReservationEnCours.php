<!-- IN PROGRESS -->

<?php if(!$powerNeeded) { exit(); }
elseif(empty($tab_reservations)) {
    echo '<div class="alert alert-danger">Vous ne disposez d\'aucune réservation pour le moment</div>';
} else {
    echo '<div class="table-responsive"><table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID                  </th>';
    echo '<th>Nom                 </th>';
    echo '<th>Prénom              </th>';
    echo '<th>Nom de la chambre   </th>';
    echo '<th>Durée               </th>';
    echo '<th>Prix                </th>';
    echo '<th>Prestations         </th>';
    echo '<th>Détails             </th>';
    echo '<th>Actions             </th>';
    echo '</tr>';
    echo '</thead>';
    foreach ($tab_reservations as $reservations) {
        $id = $reservations->get('idReservation');
        $nom = $reservations->getNomUtilisateur();
        $prenom = $reservations->getPrenomUtilisateur();
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
        echo '<td><button class="btn btn-xs btn-primary">' . $nbDetails . ' <i class="fa fa-cog" aria-hidden="true"></i></button></td>';
        echo '<td>
                        <a href="index.php?controller=admin&action=editChambre&idChambre=' . $id . '" class="btn btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Modifier</a>

                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteChambre" onclick="GETurl(id, ' . $id . ')">Supprimer</button>

                        </td>';
        echo '</tr>';


    }
    echo '</table></div>';
}
?>