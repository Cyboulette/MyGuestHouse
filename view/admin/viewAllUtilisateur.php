<div class="col-xs-12">
    <?php if (isset($tab_v) && !empty($tab_v)) {
        echo '<h1 class="page-header">Utilisateurs</h1>';
        echo '<div class="row placeholders">';

        foreach ($tab_v as $chambre){
            $nom = $chambre->get("prenomUtilisateur
            ");
            $prix = $chambre->get("prixChambre");
            $id = $chambre->get("idChambre");
            echo "
                <a href='?controller=chambre&action=read&idChambre=$id'>
                    <div class='col-xs-4 col-sm-2 col placeholder'>
                        <img src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' width='200' height='200' class='img-responsive' alt='Generic placeholder thumbnail'>
                        <h4>{$nom}</h4>
                        <span class='text-muted'>{$prix} <span class='glyphicon glyphicon-eur' aria-hidden='true'></span></span>
                      </div>
              </a>
                ";
            }
            echo '</div>';
        }else{
            echo '<div class="alert alert-danger">'."Il n'y a aucun utilisateurs pour l'instant <br> <a href='#'>Commencer à vous  développer</a>".'</div>';
        }
        ?>
</div>