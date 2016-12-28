<?php if(!$powerNeeded) { exit(); } ?>

<?php 
    if(!isset($utilisateur)){
        exit();
    }else{
        $nom=$utilisateur->get('nomUtilisateur');
        $prenom=$utilisateur->get('prenomUtilisateur');
        $email=$utilisateur->get('emailUtilisateur');
        
    }
?>

<h1 class="page-header"><?php echo $prenom.' '.$nom;?></h1>
<?php if(isset($message)) echo $message; ?>

<?php  
    echo $email;
?>




