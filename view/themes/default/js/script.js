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
} );