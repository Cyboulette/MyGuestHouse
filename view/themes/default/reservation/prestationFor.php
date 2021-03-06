<?php
/**
 * This view provide the to add and take off prestations for reservations
 **/
if(!$powerNeeded) { exit(); } ?>

<?php
if ($_GET['controller'] == 'reservation'){
    echo '<h1 class="page-header">Liste des prestations de la reservation '.$_GET['idReservation'].'</h1>';
    if(empty($tab_prestations)) {
        echo '<div class="alert alert-danger">Il n\'y a aucune prestation pour le moment</div>';
    } else {

        echo '<div class=""></div>';
        echo '<form action="index.php?controller=reservation&action=managedPrestationForReservation" method="POST">';
        echo '<div class="table-responsive"><table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Ajout</th>';
        echo '<th>Nom de la prestation</th>';
        echo '<th>Prix</th>';
        echo '</tr>';
        echo '</thead>';
        foreach ($tab_prestations as $prestation) {
            $id = $prestation->get('idPrestation');
            $nom = $prestation->get('nomPrestation');
            $prix = $prestation->get('prix');
            $checked = in_array ( $prestation , $tab_prestationsReservation);

            echo '<tr>';
            echo '<td><input type="checkbox" name="prestations[]" id="checkbox'.$id.'" value="'.$id.'"';
            if ($checked){echo 'checked';}
            echo '></td>';
            echo '<td><label for="checkbox'.$id.'">'.$nom.'</label></td>';
            echo '<td>'.$prix.' €</td>';
            echo '</tr>';
        }

        echo '</table></div>';
        echo '<div class="col-xs-6 col-sm-5 col-md-2">';
        echo '<input type="submit" class="btn btn-s btn-success btn-block" value="Valider">';
        echo "</div>";
        echo '<input type="hidden" name="idReservation" value="'.$idReservation.'"/>';
        echo '</form>';
    }
}


?>

