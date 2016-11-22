<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
  <?php 
    if(isset($displayError) && !empty($displayError)) {
      echo '<div class="alert alert-danger">'.$displayError.'</div>';
    }
    $email = (isset($_POST['email']) ? strip_tags($_POST['email']) : '');
    $password = (isset($_POST['password']) ? $_POST['password'] : '');
  ?>
  <form role="form" action="index.php?controller=utilisateur&action=connected" method="POST">
    <fieldset>
      <h2>Se connecter</h2>
      <hr class="colorgraph">

      <div class="form-group">
        <input type="email" name="email" id="email" value="<?=$email?>" class="form-control input-lg" placeholder="Adresse e-mail">
      </div>

      <div class="form-group">
        <input type="password" name="password" id="password" value="<?=$password?>" class="form-control input-lg" placeholder="Mot de passe">
      </div>

      <hr class="colorgraph">

      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
          <input type="submit" class="btn btn-lg btn-success btn-block" value="Connexion">
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="index.php?controller=utilisateur&action=register" class="btn btn-lg btn-primary btn-block">S'inscrire</a>
        </div>
      </div>
    </fieldset>
  </form>
</div>