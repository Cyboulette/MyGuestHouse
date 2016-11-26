<?php
if(isset($displayError) && !empty($displayError)) {
    echo '<div class="alert alert-danger">'.$error.'</div>';
} else {
    echo '<div class="alert alert-danger">Erreur inconnue</div>';
}
?>