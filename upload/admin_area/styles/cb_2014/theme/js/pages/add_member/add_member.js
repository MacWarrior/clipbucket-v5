$(document).ready(function () {
    jQuery('#datecreated').datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        changeMonth: true,
        dateFormat: date_format,
        changeYear: true,
        yearRange: "-56:+0"
    });
    var currentDate = new Date();
    $("#dob").datepicker("setDate", currentDate);
});