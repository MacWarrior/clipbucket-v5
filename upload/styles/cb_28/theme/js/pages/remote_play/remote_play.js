$(function() {
    $('#remote_play_form').find('.formSection h4').off('click').on({
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

    $('#remote_play_form').find('#video_password').attr('disabled', 'disabled').parent().slideUp();
    $('#remote_play_form').find('#video_users').attr('disabled', 'disabled').parent().slideUp();
    $('#remote_play_form').find('[name="broadcast"]').off('click').on('click', function () {
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

    $('#remote_play_submit_form1').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: remote_play_submit_form_url,
            type: 'POST',
            data: {
                step : 'check_link'
                ,remote_play_file_url : $('#remote_play_file_url').val()
            },
            dataType: 'json',
            beforeSend: function(){
                $('#remote_play_submit_form1').attr('disabled', true).html(remote_play_lang_checking);
            },
            success: function(data) {
                if(data.error){
                    $('#uploadMessage').html(data.error).attr('class', 'alert alert-danger').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);
                    $('#remote_play_submit_form1').attr('disabled', false).html(remote_play_lang_submit_now);
                } else {
                    $('#remote_play_form').find('input[name="title"]').val(data.filename);
                    $('#remote_play_form').find('textarea[name="description"]').val(data.filename);
                    $('#remote_play_form').find('input[name="tags"]').val(data.filename);
                    var alert_shown = false;
                    $('#remote_play_form').find('#list_tags').tagit({
                        singleField:true,
                        readOnly:false,
                        singleFieldNode: $('#remote_play_form').find('input[name="tags"]'),
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
                    $('#remote_play_submit_form1').fadeOut(250);
                    $('#second-form').slideDown(1000);
                }
            },
            //error: function(){},
            //complete: function(){}
        });
    });

    var step = 'save';
    $('#remote_play_submit_form2').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: remote_play_submit_form_url,
            type: 'POST',
            data: {
                step : step
                ,form_data : $('#remote_play_form').serialize()
            },
            dataType: 'json',
            beforeSend: function(){
                $('#remote_play_submit_form2').attr('disabled', true).html(remote_play_lang_saving);
            },
            success: function(data) {
                $('#uploadMessage').html(data.msg).show();
                setTimeout(function(){
                    $('#uploadMessage').fadeOut(500);
                }, 5000);
                if(!data.error){
                    if(step === 'save'){
                        $('#remote_play_form').find('input[name="videokey"]').attr('disabled', false).val(data.videokey);
                        $('#remote_play_form').find('input[name="remote_play_file_url"]').attr('readonly', true);
                        step='update';
                        //call progress video
                        intervalId = setInterval(function () {
                            $.post({
                                url: baseurl+'actions/progress_video.php',
                                dataType: 'json',
                                data: {
                                    ids: [data.videoid],
                                    output: 'watch_video',
                                    display_thumbs: true,
                                    display_subtitles: true
                                },
                                success: function (response) {
                                    var data = response.data;

                                    data.videos.forEach(function (video) {
                                        if ( video.percent > 0 || typeof video.percent === "undefined") {
                                            if ($('#remote_play_form').find('[name="default_thumb"]').length === 0 && typeof video.thumbs !== 'undefined' && video.thumbs.length > 0) {
                                                const thumbs = $(video.thumbs).hide();
                                                thumbs.insertBefore($('#remote_play_form').find('.pad-bottom-sm.text-right'));
                                                thumbs.slideDown('slow');

                                            }
                                            if ($('#remote_play_form').find('#subtitles_'+video.videoid).length === 0 && typeof video.subtitles !== 'undefined' && video.subtitles.length > 0) {
                                                const subtitles = $(video.subtitles).hide();
                                                subtitles.insertBefore($('#remote_play_form').find('.pad-bottom-sm.text-right'));
                                                subtitles.slideDown('slow');
                                            }
                                            slideFormSection();
                                        }
                                        if (video.status.toLowerCase() === 'processing') {
                                            //update %
                                            var process_div = $('.processing[data-id="' + video.videoid + '"]');
                                            //if process don't exist : get thumb + process div
                                            if (process_div.length === 0) {
                                                $('#remote_play_form').find('.player-holder').html(video.html);
                                            } else {
                                                process_div.find('span').html(video.percent + '%');
                                            }
                                        } else {
                                            $('#remote_play_form').find('.player-holder').html(video.html);
                                        }
                                    });

                                    if (response.all_complete) {
                                        clearInterval(intervalId);
                                    }
                                }
                            })
                        }, 30000);
                    }
                    $('#remote_play_submit_form2').attr('disabled', false).html(remote_play_lang_submit_now);
                }
            },
        });
    });
});