<?php
    // variables
    $nom = $chambre->get("nomChambre");
    $prix = $chambre->get("prixChambre");
    $superficie = $chambre->get("superficieChambre");
    $description = $chambre->get("descriptionChambre");
?>

<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2 ">
    <div class='page-header text-center'><?=$nom?></div>

    <!-- Carousel -->
    <? if (isset($tab_photo) && !empty($tab_photo)) { ?>

    <div>

        <?php foreach ($tab_photo as $key => $value) { ?>
        <?=$tab_photo[$key][0]?>
        <br>
        <?php } ?>

    </div>

    <? } else { ?>

          <div class="alert alert-danger">Il n'y a aucune photo pour linstant</div>

    <? } ?>

    <!-- Description de la chambre -->
    <div class='descriptionChambre'>
        <h4> Descriptions </h4>
        <ul>
            <li> Nom de la chambre : <?=$nom?> </li>
            <li> Prix<small>/nuit</small> : <?=$prix?> &euro; </li>
            <li> Superficie : <?=$superficie?> m<sup>2</sup> </li>
            <li> Description :
                <ul>
                    <li> <?=$description?> </li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Details de la chambre -->
    <? if (isset($tab_detail) && !empty($tab_detail)) { ?>

    <div >
        <h4>Détails </h4>
        <ul>
            <?php foreach ($tab_detail as $key => $value) { ?>
            <li> <?=$tab_detail[$key][0]?> : <?=$tab_detail[$key][1]?> </li>
            <?php } ?>
        </ul>

    </div>

    <? } else { ?>

    <div class="alert alert-danger">Il n'y a pas de details pour cette chambre</div>

    <? } ?>

    <!--Prestations de la chambre-->
    <? if (isset($tab_prestation) && !empty($tab_prestation)) { ?>

        <div>
            <div>
                <h4> Prestation </h4>
            </div>
            <div>
                <ul>

                <?php foreach ($tab_prestation as $key => $value) { ?>
                    <li> <?=$tab_prestation[$key][0]?> : <?=$tab_prestation[$key][1]?> </li>
                <?php } ?>

                </ul>
            </div>
        </div>

    <? } else { ?>

        <div class="alert alert-danger">Il n'y a pas de prestations pour cette chambre</div>
    <? } ?>


    <?php //TODO : calendar -> resarvation ?>

    <?php //TODO : bouton pour l'admin ??????? ?>

</div>


<!-- description de la chambre en div -->
<!-- 
	<div>
		<p>- Nom de la chambre : {$nom}</p>
		<p>- Prix<small>/nuit</small> : {$prix}</p>
		<p>- Suerficie : {$superficie}</p>
		<div>
			<p>- Description : </p>
			<p>{$description}</p>
		</div>
	</div>
 -->




