<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header"><?=$titreAction?></h1>
<?php if(isset($message)) echo $message; ?>

<?php
    if($type == "add") {
        $idReservation = (isset($_POST['idReservation']) ? htmlspecialchars($_POST['idReservation']):'');
        $dateDebut = (isset($_POST['dateDebut']) ? htmlspecialchars($_POST['dateDebut']):'');
        $dateFin = (isset($_POST['dateFin']) ? htmlspecialchars($_POST['dateFin']):'');
        $nom = (isset($_POST['nom']) ? htmlspecialchars($_POST['nom']):'');
        $prenom = (isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']):'');
        $idUtilisateur = (isset($_POST['idUtilisateur']) ? htmlspecialchars($_POST['idUtilisateur']):'');
        $idChambre = (isset($_POST['idChambre']) ? htmlspecialchars($_POST['idChambre']):'');
        $urlAction = 'index.php?controller=admin&action=addReservation&type=add';
        $titleBouton = 'Ajouter';
    }
    elseif($type == "edit") {
        $dateDebut = $readReservation->get('dateDebut');
        $dateFin = $readReservation->get('dateFin');
        $utilisateur = ModelUtilisateur::select($readReservation->get('idUtilisateur'));
        $nom = $utilisateur->get('nomUtilisateur');
        $prenom = $utilisateur->get('prenomUtilisateur');
        $idUtilisateur = $readReservation->get('idUtilisateur');
        $chambre = ModelChambre::select($readReservation->get('idChambre'));
        $idChambre = $chambre->get('idChambre');
        $urlAction = 'index.php?controller=admin&action=editReservation&type=edit&idReservation='.$idReservation;
        $titleBouton = 'Modifier';
    }
?>

<form class="form" role="form" method="POST" action="<?=$urlAction?>" >


    <div class="form-group">
        <label for="idUtilisateur"> Idetifiant du client </label>
        <input type="text" class="form-control" id="idUtilisateur" placeholder="Indiquez prenom de du client" value="<?=$idUtilisateur?>">
    </div>

    <div class="form-group">
        <label for="idChambre"> Id de la chambre </label>
        <input type="text" class="form-control" id="idChambre" placeholder="Indiquez l'identifiant de la chambre" value="<?=$idChambre?>">
    </div>

    <div class="form-group">
        <label for="dateDebut"> Date du début de la reservation </label>
        <input type="text" class="form-control" id="dateDebut" placeholder="Indiquez la date du debut de la reservation" value="<?=$dateDebut?>">
    </div>

    <div class="form-group">
        <label for="dateFin"> Date de la fin de la reservation </label>
        <input type="text" class="form-control" id="dateFin" placeholder="Indiquez la date de la fin de la reservation" value="<?=$dateFin?>">
    </div>

    <?php if($type == "edit") echo '<input type="hidden" name="idNews" value="'.$idReservation.'">'; ?>
    <button type="submit" class="btn btn-success"><?=$titleBouton?></button>
</form>


