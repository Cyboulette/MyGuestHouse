<h1 class="page-header">Récatitulatif de la réservation n°<?=$idReservation?></h1>

<div>
    <table class="table table-bordered">
        <tr class="active">
            <th> Client </th>
            <th> Date de la réservation</th>
        </tr>
        <tr>
            <td> <?=ucfirst($nomClient)?> <?=ucfirst($prenomClient)?> </td>
            <td> Du <?=$dateDebut?> au <?=$dateFin?> </td>
        </tr>
        <tr class="active">
            <th class="col-xs-8 col-sm-9">Description</th>
            <th>Charges</th>
        </tr>
        <tr>
            <td> Réservation de <strong><?=$nomChambre?></strong> pour un total de <strong><?=$nombreNuits?></strong> nuits</td>
            <td> <?=$prixReservation?></td>
        </tr>

        <?php foreach($prestations as $prestation) { ?>
            <tr style="border: none;">
                <td style="border-left: none; border-top: none; border-bottom: none;"> + <?=ucfirst($prestation->get('nomPrestation'))?> </td>
                <td style="border-left: none; border-top: none; border-bottom: none;"> <?=$prestation->get('prix')?> </td>
            </tr>
        <?php } ?>

        <!-- Total -->
        <tr class="info">
            <td> Pour plus d'information contactez nous ! </td>
            <td>Total <?=$prixTotal?></td>
        </tr>

    </table>
</div>


