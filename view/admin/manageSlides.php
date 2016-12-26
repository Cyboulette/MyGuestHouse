<?php if(!$powerNeeded) { exit(); } ?>
<h1 class="page-header"><?=$titreAction?></h1>
<?php if(isset($message)) echo $message; ?>

<?php 
	if($type == "add") {
		$urlSlide = (isset($_POST['urlSlide']) ? htmlspecialchars($_POST['urlSlide']):'');
		$textSlide = (isset($_POST['textSlide']) ? htmlspecialchars($_POST['textSlide']):'');
		$urlAction = 'index.php?controller=adminSlides&action=addSlide&type=add';
		$titleBouton = 'Ajouter';
	} elseif($type == "edit") {
		$idSlide = $readSlide->get('idSlide');
		$urlSlide = (isset($_POST['urlSlide']) ? htmlspecialchars($_POST['urlSlide']):$readSlide->get('urlSlide'));
		$textSlide = (isset($_POST['textSlide']) ? htmlspecialchars($_POST['textSlide']):$readSlide->get('textSlide'));
		$urlAction = 'index.php?controller=adminSlides&action=editSlide&type=edit&idSlide='.$idSlide;
		$titleBouton = 'Modifier';
	}
?>

<form class="form" role="form" method="POST" action="<?=$urlAction?>" enctype="multipart/form-data">
	<div class="form-group">
		<label for="urlSlide">Renseignez le lien vers l'image</label>
		<input type="text" class="form-control" id="urlSlide" name="urlSlide" placeholder="Indiquez le lien vers l'image" value="<?=$urlSlide?>">
		<br/>
		<div class="alert alert-info">
		<label for="slideToUpload">Ou téléchargez une image</label>
		<input type="file" accept="image/*" class="form-control" id="slideToUpload" name="urlSlide">
		</div>
	</div>


	<div class="form-group">
		<label for="textSlide">Description affichée sur l'image</label><br/>
		<textarea class="form-control" id="textSlide" rows="10" name="textSlide" placeholder="Indiquez la description qui apparaîtra au dessus de l'image"><?=$textSlide?></textarea>
	</div>

	<?php if($type == "edit") echo '<input type="hidden" name="idSlide" value="'.$idSlide.'">'; ?>
	<button type="submit" class="btn btn-success"><?=$titleBouton?></button>
</form>