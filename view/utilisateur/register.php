<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
  <?php 
    if(isset($displayError) && !empty($displayError)) {
      echo '<div class="alert alert-danger">'.$displayError.'</div>';
    }
    $email = (isset($_POST['email']) ? strip_tags($_POST['email']) : '');
    $password = (isset($_POST['password']) ? $_POST['password'] : '');
    $password_confirm = (isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '');
    $prenom = (isset($_POST['prenom']) ? strip_tags($_POST['prenom']) : '');
    $nom = (isset($_POST['nom']) ? strip_tags($_POST['nom']) : '');
  ?>
  <form role="form" action="index.php?controller=utilisateur&action=registered" method="POST">
    <fieldset>
      <h2>S'inscrire</h2>
      <hr class="colorgraph">

      <div class="form-group">
        <label for="email">Votre e-mail</label>
        <input type="email" name="email" id="email" value="<?=$email?>" class="form-control input-lg" placeholder="Saisissez votre adresse e-mail">
      </div>

      <div class="form-group">
        <label for="password">Votre mot de passe</label>
        <input type="password" name="password" id="password" value="<?=$password?>" class="form-control input-lg" placeholder="Saisissez votre mot de passe">
      </div>

      <div class="form-group">
        <label for="password_confirm">Confirmez le mot de passe</label>
        <input type="password" name="password_confirm" id="password_confirm" value="<?=$password_confirm?>" class="form-control input-lg" placeholder="Confirmez votre mot de passe">
      </div>

      <div class="form-group">
        <label for="prenom">Votre prénom</label>
        <input type="text" name="prenom" id="prenom" value="<?=$prenom?>" class="form-control input-lg" placeholder="Saisissez votre prénom">
      </div>

      <div class="form-group">
        <label for="nom">Votre nom</label>
        <input type="text" name="nom" id="nom" value="<?=$nom?>" class="form-control input-lg" placeholder="Saisissez votre nom">
      </div>
      <div class="alert alert-info text-center">
        Tous les champs sont obligatoires
      </div>
      <hr class="colorgraph">

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <input type="submit" class="btn btn-lg btn-success btn-block" value="S'inscrire">
        </div>
      </div>
    </fieldset>
  </form>
</div>