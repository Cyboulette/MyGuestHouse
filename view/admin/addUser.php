<?php if(!$powerNeeded) { exit(); } ?> 

<h1 class='page-header'>Ajouter un utilisateur</h1>

<form class="form-horizontal" method='post' action='?controller=adminUtilisateurs&action=added' enctype='multipart/form-data'>

  <div class='form-group row'>
    <label for='id_email' class="col-sm-2 control-label">E_mail : </label>
    <div class="col-sm-10">
      <input class="form-control" type='email' name='email' placeholder='email@email.com' id='id_email'>        		
    </div>
  </div>

  <div class='form-group row'>
    <label for='id_prenom' class="col-sm-2 control-label">Prenom de l'utilisateur : </label>
    <div class="col-sm-10">
      <input class="form-control" type='text' name='prenom' placeholder='Florian' id='id_nom'>
    </div>
  </div>

  <div class='form-group row'>
    <label for='id_nom' class="col-sm-2 control-label">Nom de l'utilisateur : </label>
    <div class="col-sm-10">
      <input class="form-control" type='text' name='nom' placeholder='POIROT' id='id_nom'>
    </div>
  </div>

  <div class='form-group row'>
    <label class="col-sm-2 control-label" for='id_rang'>Rang de l'utilisateur :</label>
    <div class="col-sm-10">
      <select multiple  class="form-control" name='rang' id='id_rang'>
      	<option class="form-control" value='1'>Visiteur</option>
      	<option class="form-control" value='2'>Membre</option>
      	<option class="form-control" value='3'>Administrateur</option>
      </select>
    </div>
  </div>

  <div class='form-group row'>
    <label for='id_motDePasse' class="col-sm-2 control-label">Mot de passe : </label>
    <div class="col-sm-10">
      <input class="form-control" type='password' name='motDePasse' id='id_motDePasse' placeholder='nouveau mot de passe'>
    </div>
  </div>

  <div class='form-group row'>
    <label for='id_motDePassebis' class="col-sm-2 control-label">Validation du mot de passe : </label>
    <div class="col-sm-10">
      <input class="form-control" type='password' name='motDePassebis' id='id_motDePassebis' placeholder='validation du mot de passe'>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-success" value="Ajouter">
      <a href="index.php?controller=adminUtilisateurs&action=utilisateurs" class="btn btn-danger">Annuler</a>
    </div>
  </div>
</form>

	