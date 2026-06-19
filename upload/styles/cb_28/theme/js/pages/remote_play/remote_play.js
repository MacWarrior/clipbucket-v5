var step = 'save';

$(function () {
    $('#remote_play_form').find('.formSection h4').off('click').on({
        click: function (e) {
            e.preventDefault();
            if ($(this).find('i').hasClass('glyphicon-chevron-down')) {
                $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                $(this).next().slideDown('slow');
            } else {
                $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                $(this).next().slideUp('slow');
            }
        }
    });
    $("[id^=remote_tags]").each(function (elem) {
        init_tags(this.id, available_tags, '#remote_list_' + this.name);
    });

    $('#remote_list_video_users').tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#remote_list_video_users').prevAll('#video_users'),
        animate: true,
        caseSensitive: false,
        allowSpaces: allow_username_spaces,
        beforeTagAdded: function (event, info) {
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

    $('#remote_play_submit_form1').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: remote_play_submit_form_url,
            type: 'POST',
            data: {
                step: 'check_link'
                , remote_play_file_url: $('#remote_play_file_url').val()
            },
            dataType: 'json',
            beforeSend: function () {
                $('#remote_play_submit_form1').attr('disabled', true).html(remote_play_lang_checking);
            },
            success: function (data) {
                if (data.error) {
                    $('#uploadMessage').html(data.error).attr('class', 'alert alert-danger').show();
                    setTimeout(function () {
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);
                    $('#remote_play_submit_form1').attr('disabled', false).html(remote_play_lang_submit_now);
                } else {
                    $('#remote_play_form').find('input[name="title"]').val(data.filename);
                    $('#remote_play_form').find('textarea[name="description"]').val(data.filename);
                    $('#remote_play_form').find('input[name="tags"]').val(data.filename);
                    $('#remote_play_form').find("[id^=tags]").each(function (elem) {
                        var tagsList = document.createElement('ul');
                        tagsList.id = 'list_' + this.id;
                        $(this).val(data[this.name]).attr('id', this.name);
                        $(tagsList).insertAfter($("input[name='" + this.name + "']"));
                        var alert_shown = false;

                        $('#remote_play_form').find('#' + tagsList.id).tagit({
                            singleField: true,
                            readOnly: false,
                            singleFieldNode: $('#remote_play_form').find('#' + this.id),
                            animate: true,
                            caseSensitive: false,
                            availableTags: available_tags[this.id.replace('tags_', '')],
                            allowSpaces: allow_tag_space,
                            beforeTagAdded: function (event, info) {
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
                    });
                    $('#remote_play_form').find('#list_video_users').tagit({
                        singleField: true,
                        fieldName: "tags",
                        readOnly: false,
                        singleFieldNode: $('#remote_play_form').find('#video_users'),
                        animate: true,
                        caseSensitive: false,
                        allowSpaces: allow_username_spaces,
                        beforeTagAdded: function (event, info) {
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

                    $('#remote_play_submit_form1').fadeOut(250);
                    if (data.percent === 100) {
                        $('#remote_play_form').find('.saveVideoDetails').removeAttr('disabled');
                        $('#remote_play_form').find('#button_info_tmdb').removeAttr('disabled');
                    }
                    $('#second-form').slideDown(1000);
                    $('#remote_play_submit_form2').attr('disabled', false).html(remote_play_lang_submit_now);
                }
            },
            //error: function(){},
            //complete: function(){}
        });
    });

    $('#remote_play_submit_form2').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: remote_play_submit_form_url,
            type: 'POST',
            data: {
                step: step
                , form_data: $('#remote_play_form').serialize()
            },
            dataType: 'json',
            beforeSend: function () {
                $('#remote_play_submit_form2').attr('disabled', true).html(remote_play_lang_saving);
            },
            success: function (data) {
                $('#uploadMessage').html(data.msg).show();
                setTimeout(function () {
                    $('#uploadMessage').fadeOut(500);
                }, 5000);
                if (!data.error) {
                    if (step === 'save') {
                        var hiddenField_videoId = document.createElement('input');
                        hiddenField_videoId.name = 'videoid';
                        hiddenField_videoId.id = 'videoid_remote';
                        hiddenField_videoId.type = 'hidden';
                        hiddenField_videoId.value = data.videoid;
                        if ($('#' + hiddenField_videoId.id).length === 0) {
                            $('#link_video_link form').append(hiddenField_videoId);
                        }
                        var videoid = $('#videoid_remote').val();
                        $('#remote_play_form').find('input[name="videokey"]').attr('disabled', false).val(data.videokey);
                        $('#remote_play_form').find('input[name="remote_play_file_url"]').attr('readonly', true);
                        $('#remote_play_form').find('#button_info_tmdb').attr('data-id', videoid).attr('disabled', false).on('click', function () {
                            getInfoTmdbRemote(videoid, 'movie', data.title, 1);
                        });
                        step = 'update';
                        getRemoteInfo(videoid);
                        clearInterval(intervalId);
                        //call progress video
                        intervalId = setInterval(function () {
                            getRemoteInfo(videoid);
                        }, 30000);
                    }
                    $('#remote_play_submit_form2').attr('disabled', false).html(remote_play_lang_submit_now).removeClass('borderPulse').attr('title', '');
                }
            },
        });
    });


});

function getRemoteInfo(videoid) {
    $.post({
        url: baseurl + 'actions/progress_video.php',
        dataType: 'json',
        data: {
            ids: [videoid],
            output: 'watch_video',
            display_thumbs: true,
            display_subtitles: true
        },
        success: function (response) {
            var data = response.data;

            data.videos.forEach(function (video) {
                if (video.percent > 0 || typeof video.percent === "undefined") {
                    displayThumbSection('thumb', video.videoid, video.thumbs.thumbs, $('#link_video_link'));
                    displayThumbSection('poster', video.videoid, video.thumbs.posters, $('#link_video_link'));
                    displayThumbSection('backdrop', video.videoid, video.thumbs.backdrops, $('#link_video_link'));

                    if ($('#remote_play_form').find('#subtitles_' + video.videoid).length === 0 && typeof video.subtitles !== 'undefined' && video.subtitles.length > 0) {
                        const subtitles = $(video.subtitles).hide();
                        subtitles.insertBefore($('#remote_play_form').find('.pad-bottom-sm.text-right'));
                        subtitles.slideDown('slow');
                    } else {
                        const parent_div = $('#subtitles_'+video.videoid).parents('.formSection.clear')[0];
                        $(parent_div).replaceWith(video.subtitles);
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
                    let images = document.querySelectorAll("img[data-thumbs]")
                    listenerPreviewThumbs(images);
                }
            });

            if (response.all_complete) {
                clearInterval(intervalId);
            }
        }
    });
}

function getInfoTmdbRemote(videoid, type, video_title, page, sort, sort_order) {
    showSpinner();
    $.ajax({
        url: baseurl + "actions/tmdb_info.php",
        type: "POST",
        data: {videoid: videoid, video_title: video_title, type: type, page: page, sort: sort, sort_order: sort_order},
        dataType: 'json',
        success: function (result) {
            hideSpinner();
            var modal = $('#myModal');
            modal.html(result['template']);
            modal.modal();
            $('.page-content').prepend(result['msg']);
        },
        complete: function () {
            hideSpinner();
        }
    });
}

function saveInfoTmdbRemote(tmdb_video_id, type, videoid) {
    showSpinner();
    $.ajax({
        url: baseurl + "actions/tmdb_import.php",
        type: "POST",
        data: {tmdb_video_id: tmdb_video_id, videoid: videoid, type: type, from: 'upload'},
        dataType: 'json',
        success: function (result) {
            $('.close').click();
            hideSpinner();
            if (result.success == false) {
                $('.page-content').prepend(result['msg']);
            } else {
                //remplir uploaded files
                $.each(result['video_detail'], function (key, value) {
                    var input = $('#remote_play_form').find('[name="' + key + '"]').first();
                    if (input.length > 0) {
                        if (key.includes('tag') && typeof value === 'string') {
                            var tags = value.split(',');
                            $.each(tags, function (key, value) {
                                if (value !== '') {
                                    input.parent().find('ul').first().tagit('createTag', value);
                                }
                            })
                        } else {
                            input.val(value);
                        }
                    }
                });
                //update thumbs
                if (result.id && result.html) {
                    displayThumbSection('thumb', result.id, result.html.thumbs, $('#link_video_link'));
                    displayThumbSection('poster', result.id, result.html.posters, $('#link_video_link'));
                    displayThumbSection('backdrop', result.id, result.html.backdrops, $('#link_video_link'));
                    slideFormSection();
                }
                if (result.player) {
                    //update player
                    const parent = $('input[id^="videoid_"][value="' + result.id + '"]').parents('.tab-pane.uploadFormContainer');
                    if (typeof parent.find('.player-holder video')[0] !== 'undefined') {
                        videojs(parent.find('.player-holder video')[0]).dispose();
                    }
                    if (typeof players[result.id] !== 'undefined') {
                        players[result.id] = result.player;
                    }
                    if (parent.hasClass('active')) {
                        parent.find('.player-holder').html(result.player);
                    }
                    let images = document.querySelectorAll("img[data-thumbs]")
                    listenerPreviewThumbs(images);
                }
            }
        },
        complete: function () {
            hideSpinner();
        }
    });
}