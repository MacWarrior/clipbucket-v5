$(document).ready(function(){
    init_tags('profile_tags', available_tags);

    if( typeof format_date_js !== 'undefined' ){
        $('#dob').datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            changeMonth: true,
            dateFormat: format_date_js,
            changeYear: true,
            yearRange: "-99y:+0",
            regional: lang
        });
    }

    if( mode === 'account' ) {
        $('#accountSettings').toggle();
        $('#accntSettingHead').toggleClass('accntSettingHeadarrowup')
    } else {
        $('#accntProfileSettings').toggle();
        $('#accntProfileSettingHead').toggleClass('accntSettingHeadarrowup')
    }

    $('#profile_desc').value = atob(user_profile_desc);
    $('#about_me').value = atob(user_about_me);

    if( typeof user_schools !== 'undefined' ){
        $('#schools').value = atob(user_schools);
    }
    if( typeof user_occupation !== 'undefined' ){
        $('#occupation').value = atob(user_occupation);
    }
    if( typeof user_companies !== 'undefined' ){
        $('#companies').value = atob(user_companies);
    }
    if( typeof user_hobbies !== 'undefined' ){
        $('#hobbies').value = atob(user_hobbies);
    }
    if( typeof user_movies !== 'undefined' ){
        $('#fav_movies').value = atob(user_movies);
    }
    if( typeof user_music !== 'undefined' ){
        $('#fav_music').value = atob(user_music);
    }
    if( typeof user_books !== 'undefined' ){
        $('#fav_boooks').value = atob(user_books);
    }

    $('[name="disabled_channel"]').on('change', function () {
        var inputs = $(this).parents('.field_group').find('input, textarea').not('#disabled_channel');
        inputs.each( (i,e)=> $(e).prop('disabled', ($(this).val() === 'yes')))
    });
});
