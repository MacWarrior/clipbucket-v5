$(document).ready(function(){
    init_tags('profile_tags', available_tags);

    $('#dob').datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        changeMonth: true,
        dateFormat: format_date_js,
        changeYear: true,
        yearRange: "-99y:+0",
        regional: lang
    });

    if( mode === 'account' ) {
        $('#accountSettings').toggle();
        $('#accntSettingHead').toggleClass('accntSettingHeadarrowup')
    } else {
        $('#accntProfileSettings').toggle();
        $('#accntProfileSettingHead').toggleClass('accntSettingHeadarrowup')
    }
});
