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
        $urlAction = 'index.php?controller=admin&action=addReservation&type=add';
        $titleBouton = 'Ajouter';
    }
    elseif($type == "edit") {
        $idReservation = $readReservation->get('irReservation');
        $detaDebut = $readReservation->get('dateDebut');
        $detaFin = $readReservation->get('detaFin');
        $utilisateur = ModelUtilisateur::select($readReservation->get('idUtilisateur'));
        $nom = $utilisateur->get('nomUtilisateur');
        $prenom = $utilisateur->get('prenomUtilisateur');
        $urlAction = 'index.php?controller=admin&action=editReservation&type=edit&idReservation='.$idReservation;
        $titleBouton = 'Modifier';
    }
?>

<form class="form" role="form" method="POST" action="<?=$urlAction?>" >
    <div class="form-group">
        <label for="titreNews"> Numéro de la révervation </label>
        <input type="text" class="form-control" id="titreNews" placeholder="Indiquez le numéro de la révervation" value="<?=$idReservation?>">
    </div>

    <div class="form-group">
        <label for="nom"> Nom de du client </label>
        <input type="text" class="form-control" id="nom" placeholder="Indiquez le nom de du client" value="<?=$idReservation?>">
    </div>

    <div class="form-group">
        <label for="prenom"> Prenom du client </label>
        <input type="text" class="form-control" id="prenom" placeholder="Indiquez prenom de du client" value="<?=$idReservation?>">
    </div>

    <div class="form-group">
        <label for="dateDebut"> Date du début de la reservation </label>
        <input type="text" class="form-control" id="dateDebut" placeholder="Indiquez la date du debut de la reservation" value="<?=$idReservation?>">
    </div>

    <div class="form-group">
        <label for="dateFin"> Date de la fin de la reservation </label>
        <input type="text" class="form-control" id="dateFin" placeholder="Indiquez la date de la fin de la reservation" value="<?=$idReservation?>">
    </div>
    <?php if($type == "edit") echo '<input type="hidden" name="idNews" value="'.$idReservation.'">'; ?>
    <button type="submit" class="btn btn-success"><?=$titleBouton?></button>
</form>


