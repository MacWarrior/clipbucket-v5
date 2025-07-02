$(function() {
    $('#oxygenz_remote_play_form').find('.formSection h4').off('click').on({
        click: function(e){
            e.preventDefault();
            if($(this).find('i').hasClass('glyphicon-chevron-down')){
                $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                $(this).next().slideDown('slow');
            }else{
                $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                $(this).next().slideUp('slow');
            }
        }
    });
    $("[id^=remote_tags]").each(function(elem){
        init_tags(this.id, available_tags,'#remote_list_'+this.name);
    });

    $('#remote_list_video_users').tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#remote_list_video_users').prevAll('#video_users'),
        animate: true,
        caseSensitive: false,
        allowSpaces: allow_username_spaces,
        beforeTagAdded: function (event,info) {
            if (info.tagLabel.length <= 2) {
                if (!alert_shown) {
                    alert_shown = true;
                    alert(tag_too_short);
                }
                return false;
            }
            alert_shown = false;
        }
    });

    $('#oxygenz_remote_play_form').find('#video_password').attr('disabled', 'disabled').parent().slideUp();
    $('#oxygenz_remote_play_form').find('#video_users').attr('disabled', 'disabled').parent().slideUp();
    $('#oxygenz_remote_play_form').find('[name="broadcast"]').off('click').on('click', function () {
        if ($(this).val() === 'unlisted') {
            $(this).closest('form').find('#video_password').attr('disabled', false).parent().slideDown();
            $(this).closest('form').find('#video_users').attr('disabled', 'disabled').parent().slideUp();
        } else if ($(this).val() === 'private') {
            $(this).closest('form').find('#video_users').attr('disabled', false).parent().slideDown();
            $(this).closest('form').find('#video_password').attr('disabled', 'disabled').parent().slideUp();
        } else {
            $(this).closest('form').find('#video_password').attr('disabled', 'disabled').parent().slideUp();
            $(this).closest('form').find('#video_users').attr('disabled', 'disabled').parent().slideUp();
        }
    });

    $('#oxygenz_remote_play_submit_form1').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: oxygenz_remote_play_submit_form_url,
            type: 'POST',
            data: {
                step : 'check_link'
                ,oxygenz_remote_play_file_url : $('#oxygenz_remote_play_file_url').val()
            },
            dataType: 'json',
            beforeSend: function(){
                $('#oxygenz_remote_play_submit_form1').attr('disabled', true).html(oxygenz_remote_play_lang_checking);
            },
            success: function(data) {
                if(data.error){
                    $('#uploadMessage').html(data.error).attr('class', 'alert alert-danger').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);
                    $('#oxygenz_remote_play_submit_form1').attr('disabled', false).html(oxygenz_remote_play_lang_submit_now);
                } else {
                    $('#oxygenz_remote_play_form').find('input[name="title"]').val(data.filename);
                    $('#oxygenz_remote_play_form').find('textarea[name="description"]').val(data.filename);
                    $('#oxygenz_remote_play_form').find('input[name="tags"]').val(data.filename);
                    var alert_shown = false;
                    $('#oxygenz_remote_play_form').find('#list_tags').tagit({
                        singleField:true,
                        readOnly:false,
                        singleFieldNode: $('#oxygenz_remote_play_form').find('input[name="tags"]'),
                        animate:true,
                        caseSensitive:false,
                        availableTags: available_tags,
                        beforeTagAdded: function (event,info) {
                            if (info.tagLabel.length <= 2) {
                                if (!alert_shown) {
                                    alert_shown = true;
                                    alert(tag_too_short);
                                }
                                return false;
                            }
                            alert_shown = false;
                        }
                    });
                    $('#oxygenz_remote_play_submit_form1').fadeOut(250);
                    $('#second-form').slideDown(1000);
                }
            },
            //error: function(){},
            //complete: function(){}
        });
    });

    var step = 'save';
    $('#oxygenz_remote_play_submit_form2').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: oxygenz_remote_play_submit_form_url,
            type: 'POST',
            data: {
                step : step
                ,form_data : $('#oxygenz_remote_play_form').serialize()
            },
            dataType: 'json',
            beforeSend: function(){
                $('#oxygenz_remote_play_submit_form2').attr('disabled', true).html(oxygenz_remote_play_lang_saving);
            },
            success: function(data) {
                $('#uploadMessage').html(data.msg).show();
                setTimeout(function(){
                    $('#uploadMessage').fadeOut(500);
                }, 5000);
                if(!data.error){
                    if(step === 'save'){
                        $('#oxygenz_remote_play_form').find('input[name="videokey"]').attr('disabled', false).val(data.videokey);
                        $('#oxygenz_remote_play_form').find('input[name="oxygenz_remote_play_file_url"]').attr('readonly', true);
                        step='update';
                    }
                    $('#oxygenz_remote_play_submit_form2').attr('disabled', false).html(oxygenz_remote_play_lang_submit_now);
                }
            },
        });
    });
});