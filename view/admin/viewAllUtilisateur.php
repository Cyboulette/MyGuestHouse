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

    <ul class='nav nav-tabs' role='tablist'>
        <li <?php if(!isset($_GET['mode'])&&$mode='all'){echo'class="active"';} ControllerDefault::active('adminUtilisateurs', 'utilisateurs', 'all'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=all' > Tout <span class='badge'>  <?php echo count(ModelReservation::getReservationsEnAttente()) ?> </span></a></li>
        <li <?php if(!isset($_GET['mode'])&&$mode='admin'){echo'class="active"';} ControllerDefault::active('adminUtilisateurs', 'utilisateurs', 'admin'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=admin' > Admin <span class='badge'>  <?php echo count(ModelReservation::getReservationsEnCours()) ?> </span></a></li>
        <li <?php if(!isset($_GET['mode'])&&$mode='membre'){echo'class="active"';} ControllerDefault::active('adminUtilisateurs', 'utilisateurs', 'membre'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=membre' > Membre <span class='badge'>  <?php echo count(ModelReservation::getReservationsAnnulee()) ?> </span></a></li>
        <li <?php if(!isset($_GET['mode'])&&$mode='visiteur'){echo'class="active"';} ControllerDefault::active('adminUtilisateurs', 'utilisateurs', 'visiteur'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=visiteur' > Visiteur <span class='badge'>  <?php echo count(ModelReservation::getReservationsFinis()) ?> </span></a></li>
        <li <?php if(!isset($_GET['mode'])&&$mode='nonValide'){echo'class="active"';} ControllerDefault::active('adminUtilisateurs', 'utilisateurs', 'nonValide'); ?> ><a href='index.php?controller=adminUtilisateurs&action=utilisateurs&mode=nonValide' > Non Validé <span class='badge'>  <?php echo count(ModelReservation::getReservationsFinis()) ?> </span></a></li>
    </ul>