<div class="container">
    <div class="row rooms">
        <div class="col-lg-12 titleRoom">
            <h1 class="colorCustom"><?=$titreNews?></h1>
            <em>Actualité publiée le : <?=date('j/m/Y', strtotime($dateNews))?></em>
            <hr/>
            <p><?=$contenuNews?></p>
        </div>
    </div>
</div>

<a href="index.php" class="btn btn-red bgCustom">&laquo; Retour à l'accueil de notre site</a>