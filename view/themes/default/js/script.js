$('*').html().replace("Administration","colour");

// Script for datePicker
$( function() {
    $('#datepickerDebut, #datepickerFin').datepicker({
        language: "fr",
        datesDisabled : ['2017-01-01', '2017-01-01'],
        format: "yyyy-mm-dd"

    });
    /*
     $("#datepickerDebut").datepicker();
     $("#datepickerDebut").datepicker("option", "showAnim", "drop");
     $("#datepickerFin").datepicker();
     $("#datepickerFin").datepicker("option", "showAnim", "drop");*/
} );