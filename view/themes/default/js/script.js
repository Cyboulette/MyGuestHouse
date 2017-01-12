$('*').html().replace("Administration","colour");

$('.btnDeleteReservation').on('click', function(e) {
    e.preventDefault();
    $("#deleteReservation .modal-body").html('<div class="loader"></div><br/><div class="text-center"><em>Chargement en cours</em></div>');
    $('#deleteReservation').modal('toggle');
    var idReservation = $(this).attr('data-id');
    var dataToPost = 'idReservation='+encodeURIComponent(idReservation);
    $.ajax({
        type: "POST",
        url: 'index.php?controller=Reservation&action=deleteReservationForm',
        data: dataToPost,
        dataType: 'json',
        success: function(retour) {
            console.log(retour);
            $("#deleteReservation .modal-body").html(retour.message);
        },
        error: function(retour) {
            console.log(retour);
        }
    });
});

// Script for datePicker
$( function() {
    if(typeof date !== "undefined") {
        $('#datepickerDebut, #datepickerFin').datepicker({
            language: "fr",
            format: "dd/mm/yyyy",
            datesDisabled: date

        });
    }

    $('#btnCalcul').on('click', function(e) {
        e.preventDefault();
        $(".infoCalcul").hide();
        var dateDebut = new Date($('#datepickerDebut').val().split(/\//).reverse().join('-'));
        var dateFin = new Date($('#datepickerFin').val().split(/\//).reverse().join('-'));
        var timeDiff = dateFin.getTime() - dateDebut.getTime();
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        var message, prix, duree = null;

        if(diffDays < 0) {
            message = '<div class="alert alert-danger">Vous ne pouvez pas choisir une date de fin inférieure à votre date de début</div>';
        } else {
            message = null;
            var prixChambre = $('.prixChambre').val();
            if(prixChambre != null && prixChambre > 0) {
                var prixTotal = diffDays * prixChambre;
                if(diffDays > 1) {
                    var text = ' nuits';
                } else {
                    var text = ' nuit';
                }
                $(".duree").html(diffDays + text);
                $(".prix").html(prixTotal + ' €');
                $(".infoCalcul").show();
            } else {
                message = '<div class="alert alert-danger">Impossible de récupérer le prix de la chambre</div>';
            }
        }
        if(message != null) {
            $(".messageCalcul").show();
            $(".messageCalcul").html(message);
        } else {
            $(".messageCalcul").hide();
            $(".messageCalcul").html("");
        }
    });
} );