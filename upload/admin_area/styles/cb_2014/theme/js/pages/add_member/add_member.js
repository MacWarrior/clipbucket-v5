$(document).ready(function () {
    $("#dob").datepicker({
        format: 'yyyy-mm-dd', //TODO : Use config date_format
        startDate: '-99y',
        endDate: '0'
    });

});