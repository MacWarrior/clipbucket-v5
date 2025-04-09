$(document).ready(function () {
    $('#dob').datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        changeMonth: true,
        dateFormat: format_date_js,
        changeYear: true,
        yearRange: "-99y:+0",
        regional: language
    });

});