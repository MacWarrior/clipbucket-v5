function display_tab(divId) {
    $('ul.nav-tabs:not(.resolutions,.interfaces) li').removeClass('active');
    $('ul.nav-tabs:not(.resolutions,.interfaces) li > a[href=\'' + divId + '\'').parent().addClass('active');
    $('div.tab-content div:not(.resolutions,.interfaces)').removeClass('active');
    $(divId).addClass('active');
    setHash(divId);
}

function setHash(hash) {
    window.location.hash = hash;
    $("#main_form").attr("action", hash);
}

$(document).ready(function () {
    if (window.location.hash === '') {
        setHash($('ul.nav-tabs:not(.resolutions) li:first a').attr('href'));
    } else {
        display_tab(window.location.hash);
    }

    $('ul.nav-tabs:not(.resolutions) li a').click(function () {
        setHash($(this).attr('href'));
    });

    // Hack : Bootstrap 3.X won't work with tabs in tabs
    $('ul.nav-tabs.resolutions a').click(function () {
        if (!$(this).parent().hasClass('active')) {
            let href = $(this).attr('href');
            $('#' + href).addClass('active').siblings().removeClass('active');
        }
    });
    $('ul.nav-pills.interfaces a').click(function () {
        if (!$(this).parent().hasClass('active')) {
            let href = $(this).attr('href');
            $('#' + href).addClass('active').siblings().removeClass('active');
        }
    });

    $("#mail_type").change(function () {
        if ($(this).val() === 'mail') {
            $('.config_smtp').hide();
        } else {
            if ($("#smtp_auth:checked").length === 0) {
                $('.config_smtp:not(.config_smtp_auth)').show();
            } else {
                $('.config_smtp').show();
            }
        }
    });

    const autoDisabled = [
        'video'
        ,'photo'
        ,'channel'
        ,'collection'
    ];

    autoDisabled.forEach(function (elem) {
        $('#display_'+elem+'_comments').change(function () {
            let parent = $('#'+elem+'_comments');
            if (!$(this).prop('checked')) {
                parent.prop('checked',false).prop('disabled',true);
            } else {
                parent.prop('disabled',false);
            }
        });
    });

    $("#smtp_auth").change(function () {
        if ($("#smtp_auth:checked").length === 1) {
            $('.config_smtp_auth').show();
        } else {
            $('.config_smtp_auth').hide();
        }
    });

    $("input[name='conversion_type']").change(function () {
        let inputs_mp4 = ['stay_mp4', 'keep_audio_tracks', 'keep_subtitles'];
        if (this.value === 'mp4') {
            inputs_mp4.forEach(function (input) {
                $('#' + input).prop('disabled', false);
                $('#' + input + '_hidden').prop('disabled', true);
            });
        } else {
            inputs_mp4.forEach(function (input) {
                $('#' + input).prop('disabled', true);
                $('#' + input + '_hidden').prop('disabled', false);
            });
        }
    });

    $('#discord_error_log').change(function () {
        let parent = $('#discord_webhook_url');
        if (!$(this).prop('checked')) {
            parent.prop('disabled',true);
        } else {
            parent.prop('disabled',false);
        }
    });
    $('#enable_tmdb').change(function () {
        let button = $('#tmdb_token_test');
        if (!$(this).prop('checked')) {
            button.addClass('disabled');
        } else {
            button.removeClass('disabled').attr('title','');
        }
    });

    $('#tmdb_token').keyup(function(){
        $('#tmdb_token_test').removeClass('glyphicon-ok glyphicon-remove').addClass('glyphicon-refresh');
    });

    $('#tmdb_token_test').click(function (e) {
        if( $(this).hasClass('disabled') ){
            return;
        }

        e.preventDefault();
        $.ajax({
            url: "/actions/test_tmdb.php",
            type: "POST",
            data: {token: $('#tmdb_token').val()},
            dataType: 'json',
            beforeSend : function(){
                $('#tmdb_token_test').removeClass('glyphicon-ok glyphicon-remove glyphicon-refresh').html(loading_img);
            },
            success: function (result) {
                if( result['msg'] === 'OK' ){
                    $('#tmdb_token_test').html('').removeClass('glyphicon-remove glyphicon-refresh').addClass('glyphicon-ok');
                } else {
                    $('#tmdb_token_test').html('').removeClass('glyphicon-refresh glyphicon-ok').addClass('glyphicon-remove');
                }
            }
        });
    });

    $.each({
        'enable_video_genre': 'tmdb_get_genre'
        , 'enable_video_actor': 'tmdb_get_actors'
        , 'enable_video_producer': 'tmdb_get_producer'
        , 'enable_video_executive_producer': 'tmdb_get_executive_producer'
        , 'enable_video_director': 'tmdb_get_director'
        , 'enable_video_crew': 'tmdb_get_crew'
        , 'enable_video_poster': 'tmdb_get_poster'
        , 'enable_video_backdrop': 'tmdb_get_backdrop'
        , 'enable_tmdb': 'tmdb_token'
        , 'enable_tmdb_mature_content': 'tmdb_mature_content_age'

    }, function (index, value) {

        $('#'+index).change(function () {
            let input_to_disable = [value];
            if( $(this).prop('checked') ) {
                $('#' + input_to_disable).prop('disabled', false).attr('title','');
                $('#' + input_to_disable + '_hidden').prop('disabled', true);
            } else {
                $('#' + input_to_disable).prop('disabled', true);
                $('#' + input_to_disable + '_hidden').prop('disabled', false);
            }
        })
    });
});
