var uploader;
var ids_to_check_progress = [];
var intervalId;
var players = [];
$(document).ready(function(){
    var uploadurl = baseurl+'actions/file_uploader.php';
    if(uploadScriptPath !== ''){
        uploadurl = uploadScriptPath;
    }

    uploader = new plupload.Uploader({
        browse_button: 'selectFiles',
        dragdrop: true,
        drop_element: 'dragDrop',
        runtimes : 'html5,silverlight,html4',
        url : uploadurl,
        file_data_name : 'Filedata',
        chunk_size: chunk_upload ? max_upload_size : false,
        max_file_size : max_file_size,
        filters: {
            mime_types : [
                { title : 'Video files', extensions : video_extensions }
            ]
        },

        init: {
            FilesRemoved: function(up) {
                reFreshTabs(up);
            }
        }
    });

    var filesUploaded = 0;
    var error = '';

    function reFreshTabs(up)
    {
        // creating the selected files list
        var ul = $('#selectedFilesList');
        var li = false;
        var index = 0;
        var uploadForm = $('#updateVideoInfoForm.template').clone();
        var oneUploadForm = false;
        var uploadForms = [];
        plupload.each(up.files, function(file) {
            index++;
            if($('#tab'+index).length === 0){
                li = document.createElement('li');
            }else{
                ul.find('#'+index).removeClass('active');
                $('#tab'+index).removeClass('active');
                return;
            }
            var link = document.createElement('a');
            link.href = '#tab'+index;
            link.setAttribute('data-toggle', 'tab');
            if(up.files.length < 8){
                link.innerHTML = '(' + index + ') ' + file.name.substring(0, 10);
            } else {
                link.innerHTML = '(' + index + ') ';
            }

            oneUploadForm = $(uploadForm).clone().get(0);
            oneUploadForm.className = 'updateVideoInfoForm';
            oneUploadForm.id = '';
            var wrapperDiv = document.createElement('div');
            wrapperDiv.id = 'tab'+index;

            if(index === up.files.length){
                li.className = 'active';
                wrapperDiv.className = 'tab-pane active uploadFormContainer';
            } else {
                wrapperDiv.className = 'tab-pane uploadFormContainer';
            }
            $(oneUploadForm).find(".cancel_button").attr('to_cancel',index);
            $(oneUploadForm).find("input[name='title']").val(file.data.title);
            $(oneUploadForm).find("textarea[name='description']").val(file.data.description);
            $(oneUploadForm).find("input[name='location']").val(file.data.location);
            $(oneUploadForm).find("input[name='datecreated']").val(file.data.datecreated);
            $(oneUploadForm).find("input[name='video_password']").val(file.data.video_password);
            $(oneUploadForm).find("select[name='country']").val(file.data.country);
            $(oneUploadForm).find("textarea[name='video_users']").val(file.data.video_users);
            $(oneUploadForm).find("input[name='broadcast'][value='"+file.data.broadcast+"']").prop('checked', true);
            $(oneUploadForm).find("input[name='allow_comments'][value='"+file.data.allow_comments+"']").prop('checked', true);
            $(oneUploadForm).find("input[name='comment_voting'][value='"+file.data.comment_voting+"']").prop('checked', true);
            $(oneUploadForm).find("input[name='allow_rating'][value='"+file.data.allow_rating+"']").prop('checked', true);
            $(oneUploadForm).find("input[name='allow_embedding'][value='"+file.data.allow_embedding+"']").prop('checked', true);
            $(oneUploadForm).find("[id^=tags]").each(function(elem) {
                var tagsList = document.createElement('ul');
                tagsList.id = 'list_' + this.id + '_' + index;
                $(this).val(file.data[this.name]).attr('id', this.name + index);
                $(tagsList).insertAfter($(oneUploadForm).find("input[name='"+this.name+"']"));
                var alert_shown = false;

                $(oneUploadForm).find('#' + tagsList.id).tagit({
                    singleField: true,
                    readOnly: false,
                    singleFieldNode: $(oneUploadForm).find('#' +this.id),
                    animate: true,
                    caseSensitive: false,
                    availableTags: available_tags,
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
            $(oneUploadForm).find('#list_video_users').tagit({
                singleField: true,
                fieldName: "tags",
                readOnly: false,
                singleFieldNode: $(oneUploadForm).find('#video_users'),
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
            $(oneUploadForm).find('#video_password').attr('disabled', 'disabled').parent().slideUp();
            $(oneUploadForm).find('#video_users').attr('disabled', 'disabled').parent().slideUp();
            $(oneUploadForm).find('[name="broadcast"]').off('click').on('click', function () {
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

            $(oneUploadForm).find('#button_info_tmdb').on('click', function () {
                var videoid = $(oneUploadForm).find('#videoid_' + index).val();
                getInfoTmdb(videoid, 'movie',file.data.title, 1);
            });
            if(file.data.broadcast === 'unlisted'){
                $(oneUploadForm).find('#video_password').attr('disabled',false);
            } else if(file.data.broadcast === 'private') {
                $(oneUploadForm).find('#video_users').attr('disabled',false);
            }

            $.each(file.data['category[]'],function(index, value){
                $(oneUploadForm).find("input[name='category[]'][value='"+value+"']").prop('checked', true);
            });

            if( file.show_duration === true ){
                $(oneUploadForm).find('#duration').removeAttr('disabled').parent().removeClass('hidden');
            }

            if( file.percent === 100 ){
                $(oneUploadForm).find('.saveVideoDetails').removeAttr('disabled');
            }

            wrapperDiv.appendChild(oneUploadForm);
            uploadForms.push(wrapperDiv);

            li.id = index;
            li.appendChild(link);
            ul.append(li);
        });

        $('#allUploadForms').append(uploadForms);

        $("#allUploadForms input, " +
            "#allUploadForms textarea, " +
            "#allUploadForms select "
        ).change(function() {
            var filename = $(this).closest('form').find("input[name='file_name']").val();
            var inputName = $(this).attr('name');
            var inputType = $(this).attr('type');

            var inputValue;
            if( inputType !== 'checkbox' ){
                inputValue = $(this).val();
            } else {
                inputValue = [];
                $.each($(this).closest('form').find("input[name='"+inputName+"']:checked"), function(){
                    inputValue.push($(this).val());
                });
            }

            plupload.each(up.files, function(file) {
                if( file.file_name === filename ){
                    file.data[inputName] = inputValue;
                }
            });
        });
    }

    uploader.init();

    uploader.bind('FilesAdded', function(up, uploadedFiles) {
        let i;
        $("#uploadMore").addClass("hidden");
        for(i = 0; i < uploadedFiles.length; i++) {
            const filename = uploadedFiles[i].name;
            let filename_without_extension = filename.substring(0, filename.lastIndexOf('.'));
            if( filename_without_extension.length > max_video_title ){
                filename_without_extension = filename_without_extension.substring(0, max_video_title);
            }
            uploadedFiles[i].data = [];
            uploadedFiles[i].data.title = filename_without_extension;
            uploadedFiles[i].data.description = filename_without_extension;
            uploadedFiles[i].data.tags = '';
            uploadedFiles[i].data.country = default_country_iso2;
            uploadedFiles[i].data.location = '';
            uploadedFiles[i].data.datecreated = date_format_time;
            uploadedFiles[i].data.broadcast = '';
            uploadedFiles[i].data.video_password = '';
            uploadedFiles[i].data.video_users = '';
            uploadedFiles[i].data.allow_comments = 'yes';
            uploadedFiles[i].data.comment_voting = 'yes';
            uploadedFiles[i].data.allow_rating = 'yes';
            uploadedFiles[i].data.allow_embedding = 'yes';
            if (typeof collection_id != 'undefined') {
                uploadedFiles[i].data.collection_id = collection_id;
            }
            uploadedFiles[i].data['category[]'] = [get_default_cid];
            uploadedFiles[i].data.unique_id = (Math.random() + 1).toString(36).substring(7);
        }

        reFreshTabs(up);

        $.each( uploadedFiles, function( key, fileNow ) {
            var currentTitle = fileNow.name,
                plFileId = fileNow.data.unique_id;

            let html = '<h5 class="realProgTitle_'+plFileId+'">'+currentTitle+'</h5>' +
                '<button class="clearfix cancel_button btn btn-danger" to_cancel="'+plFileId+'" style="float:right; margin-top: -8px; margin-left:10px;">' +
                    cancel_uploading +
                '</button>' +
                '<div class="progress">' +
                    '<div class="progress-bar progress-bar-striped progress-bar_'+plFileId+'" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0;">' +
                        '<span class="realProgText_'+plFileId+'"></span>' +
                    '</div>' +
                '</div>';

            $(".realProgressBars").append(html);
        });

        var index = 1;
        for (i = 0; i < up.files.length; i++ ){
            if( up.files[i].file_name !== undefined ){
                var hiddenField_fileName = document.createElement('input');
                hiddenField_fileName.name = 'file_name';
                hiddenField_fileName.type = 'hidden';
                hiddenField_fileName.value = up.files[i].file_name;
                $('#tab'+index+' form').append(hiddenField_fileName);
            }

            if( up.files[i].show_duration === true ){
                $('#tab'+index+' #duration').removeAttr('disabled').parent().removeClass('hidden');
            }

            if( up.files[i].percent < 100 ){
                $('#tab'+index+' .saveVideoDetails').attr('disabled',true);
            }
            index++;
        }

        slideFormSection();

        $(".cancel_button").on('click',function(e) {
            e.preventDefault();
            var toCancel = $(this).attr('to_cancel');
            $(this).attr('disabled',true);
            $(this).text('Canceled');

            /** cancel un upload et appel l'element suivant */
            up.abort(toCancel);

            $(this).unbind().remove();
            $('.progress-bar_'+toCancel).addClass('progress-bar-danger');
            $('.realProgText_'+toCancel).text('Canceled');
            $("#uploadMessage").removeClass("hidden").html('Upload has been canceled').attr('class', 'alert alert-danger container');
            setTimeout(function(){
                $("#uploadMessage").addClass('hidden');
            }, 5000);
        });

        $('#uploaderContainer').toggleClass('hidden');
        $('#uploadDataContainer').toggleClass('hidden');
        $('.uploadingProgressContainer').show();
        $('.allProgress').removeClass('hidden');
        up.start();
    });

    uploader.bind('BeforeUpload', function(uploader, file){
        $('#fileUploadProgress').removeClass('hidden');
        $('.progress-container').removeClass('hidden');

        //give params for $_POST
        $.extend(uploader.settings.params, {
            unique_id : file.data.unique_id
            ,collection_id : file.data.collection_id
        });
    });

    uploader.bind('FileUploaded', function(up, fileDetails, response) {
        var serverResponse = $.parseJSON(response.response);
        var id_error = '';
        if (serverResponse.error) {
            error = serverResponse.error;
            $('.progress-bar_'+fileDetails.id).addClass('progress-bar-danger');
            id_error = fileDetails.id;
        } else {
            filesUploaded++;
        }
        $('#overallProgress').css('width', ((100/up.files.length)*(filesUploaded))+"%");
        $('#overallProgress').parents('.row').find('#uploadedFilesInfo').text('Inserted ' + (filesUploaded) + ' of ' + up.files.length);
        var index = 1;
        plupload.each(up.files,function(file) {
            if( file.id === fileDetails.id ){
                if (id_error === file.id) {
                    $('#tab'+index+' form').find(':input').attr('disabled','disabled');
                } else {
                    file.file_name = serverResponse.file_name;
                    var hiddenField_fileName = document.createElement('input');
                    hiddenField_fileName.name = 'file_name';
                    hiddenField_fileName.id = 'file_name_' + index;
                    hiddenField_fileName.type = 'hidden';
                    hiddenField_fileName.value = serverResponse.file_name;
                    $('#tab' + index + ' form').append(hiddenField_fileName);
                    var hiddenField_videoId = document.createElement('input');
                    hiddenField_videoId.name = 'videoid';
                    hiddenField_videoId.id = 'videoid_' + index;
                    hiddenField_videoId.type = 'hidden';
                    hiddenField_videoId.value = serverResponse.videoid;
                    ids_to_check_progress.push(serverResponse.videoid);
                    if ($('#' + hiddenField_videoId.id).length === 0) {
                        $('#tab' + index + ' form').append(hiddenField_videoId);
                    }

                    if(serverResponse.extension === 'mp4' && stay_mp4 === 'yes' ){
                        file.show_duration = true;
                        $('#tab'+index+' #duration').removeAttr('disabled').parent().removeClass('hidden');
                    } else {
                        file.show_duration = false;
                    }

                    $('#' + index + ' a').on('click', function () {
                        $('.player-holder video').each(function (index, element) {
                            videojs(element).dispose();
                        });
                        $('.player-holder').html('');
                        const index = $(this).parent().attr('id');
                        const video_id = $('#videoid_' + index).val();
                        $('#tab' + index).find('.player-holder').html(players[video_id]);
                    });
                    $('#tab'+index+' .saveVideoDetails').removeAttr('disabled');
                    getUpdate();
                }
            }
            index++
        });

        $('.updateVideoInfoForm').on({
            submit: function(e){
                e.preventDefault();

                var data = $(this).serialize();
                data += '&updateVideo=yes';
                $.ajax({
                    url : uploadurl,
                    type : 'post',
                    data : data,
                    success: function(msg){
                        msg = $.parseJSON(msg);
                        $('#uploadMessage').removeClass('hidden');
                        if(msg.error){
                            $('#uploadMessage').html(msg.error.val).attr('class', 'alert alert-danger container');
                        } else {
                            $('#uploadMessage').html(msg.valid).attr('class', 'alert alert-success container');

                            $('#tab'+index+' .saveVideoDetails').attr('disabled',true);

                            setTimeout(function(){
                                $('#uploadMessage').addClass('hidden');
                            }, 4000);
                        }
                        $('html,body').animate({
                            scrollTop: $('body').offset().top
                        }, 'medium');
                    }
                }).fail(function(err){
                    console.log(err);
                });
            }
        });
    });

    $(document).bind('chunkuploaded', function(event, result) {
        let response = $.parseJSON(result.response);
        let wanted_unique_id = result._options.params.unique_id;

        if (response.error) {
            error = response.error;

            uploader.abort(wanted_unique_id);
            $('.progress-bar_'+wanted_unique_id).addClass('progress-bar-danger');
            $('.realProgText_'+wanted_unique_id).text('Upload failed');
            $(".cancel_button[to_cancel='" + wanted_unique_id + "']").attr('disabled',true);
            setTimeout(function(){
                $("#uploadMessage").html(response.error).addClass('hidden');
            }, 5000);
        }
    });

    uploader.bind('UploadProgress', function(up, file) {
        // this the unique ID assigned to each file upload
        var pluploadFileId = file.data.unique_id,
            filePercentage = file.percent;

        $('.progress-bar_'+pluploadFileId).css("width",filePercentage+"%");
        $('.realProgText_'+pluploadFileId).text(filePercentage + pourcent_completed);
        if (filePercentage === 100) {
            $(".cancel_button[to_cancel='" + pluploadFileId + "']").attr('disabled',true).fadeOut('slow');
            if (!$('.progress-bar_'+pluploadFileId).hasClass('progress-bar-danger')) {
                $('.progress-bar_'+pluploadFileId).addClass('progress-bar-success');
            }
        }
    });

    uploader.bind('UploadComplete', function(plupload, files){
        $("#fileUploadProgress").addClass('hidden');
        $("#uploadMore").removeClass('hidden');
        $(".uploadingProgressContainer").hide();
        uploader.refresh();
        if (error.length > 0 ) {
            $("#uploadMessage").html('');
            $("#uploadMessage").append(error).attr('class', 'alert alert-danger container');
            error = '';
        } else {
            $("#uploadMessage").html('File uploaded successfully').attr('class', 'alert alert-success container');
            setTimeout(function(){
                $("#uploadMessage").addClass('hidden');
            }, 5000);
        }
    });

    uploader.bind('Error', function(up, err) {
        $("#uploadMessage").removeClass('hidden');
        if(err){
            $("#uploadMessage").html(err.message).attr('class', 'alert alert-danger container');
        }
        setTimeout(function(){
            $("#uploadMessage").addClass('hidden');
        }, 8000);
    });

    $("#files a").click(function(e){
        e.preventDefault();
        $(this).tab("show");
    });

    $("#uploadMoreVideos").on({
        click: function(e){
            e.preventDefault();
            $("#uploaderContainer").removeClass('hidden');
            $("#uploadDataContainer").addClass('hidden');
        }
    });


    window.onbeforeunload = function() {
        if ($('.uploadingProgressContainer').is(':visible') === true) {
            return 'Uploading is in progress, are you sure you want to navigate away from this page?';
        }
        return null;
    };
});

function getInfoTmdb(videoid, type, video_title, page,sort, sort_order) {
    showSpinner();
    $.ajax({
        url: baseurl+"actions/info_tmdb.php",
        type: "POST",
        data: {videoid: videoid, video_title:video_title, type: type,page: page,sort: sort, sort_order: sort_order },
        dataType: 'json',
        success: function (result) {
            hideSpinner();
            var modal = $('#myModal');
            modal.html(result['template']);
            modal.modal();
            $('.page-content').prepend(result['msg']);
        }
    });
}

function saveInfoTmdb(tmdb_video_id, type, videoid) {
    showSpinner();
    $.ajax({
        url: baseurl+"actions/import_tmdb.php",
        type: "POST",
        data: {tmdb_video_id: tmdb_video_id, videoid: videoid, type: type},
        dataType: 'json',
        success: function (result) {
            $('.close').click();
            hideSpinner();
            if (result.success == false) {
                $('.page-content').prepend(result['msg']);
            } else {
                //remplir uploaded files
                var index = 1;
                plupload.each(uploader.files, function (file) {
                    if (file.file_name === result['video_detail']['file_name']) {
                        $.each(result['video_detail'], function (key, value) {
                            file.data[key] = value;
                            var input = $('#tab' + index).find('[name="' + key + '"]').first();
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
                    }
                    index++;
                });
            }
        },
    });
}

function getUpdate() {
    clearInterval(intervalId);
    if (ids_to_check_progress.length > 0) {
        intervalId = setInterval(function () {
            $.post({
                url: baseurl+'actions/progress_video.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress,
                    output: 'watch_video',
                    display_thumbs: true,
                    display_subtitles: true
                },
                success: function (response) {
                    var data = response.data;

                    data.videos.forEach(function (video) {
                        if ( video.percent > 0 || typeof video.percent === "undefined") {
                            if ($('input[id^="videoid_"][value="' + video.videoid + '"]').parent().find('[name="default_thumb"]').length === 0 &&  typeof video.thumbs !== 'undefined' && video.thumbs.length > 0) {
                                const thumbs = $(video.thumbs).hide();
                                thumbs.insertBefore($('input[id^="videoid_"][value="' + video.videoid + '"]').parent().find('.pad-bottom-sm.text-right'));
                                thumbs.slideDown('slow');
                            }
                            if (video.status.toLowerCase() == 'successful' && $('input[id^="videoid_"][value="' + video.videoid + '"]').parent().find('#subtitles_'+video.videoid).length === 0 && typeof video.subtitles !== 'undefined' && video.subtitles.length > 0) {
                                const subtitles = $(video.subtitles).hide();
                                subtitles.insertBefore($('input[id^="videoid_"][value="' + video.videoid + '"]').parent().find('.pad-bottom-sm.text-right'));
                                subtitles.slideDown('slow');
                            }
                            slideFormSection();
                        }
                        const parent = $('input[id^="videoid_"][value="'+video.videoid+'"]').parents('.tab-pane.uploadFormContainer');
                        if (video.status.toLowerCase() === 'processing') {
                            //update %
                            var process_div = $('.processing[data-id="' + video.videoid + '"]');
                            //if process don't exist : get thumb + process div
                            if (process_div.length === 0) {
                                players[video.videoid] = video.html;
                                if (parent.hasClass('active')) {
                                    parent.find('.player-holder').html(video.html);
                                }
                            } else {
                                process_div.find('span').html(video.percent + '%');
                            }
                        } else {
                            players[video.videoid] = video.html;
                            //reset html only if tab is active and player not already initialized
                            if (parent.hasClass('active') && parent.find('.player-holder video').length <= 0) {
                                parent.find('.player-holder').html(video.html);
                            }
                        }
                    });

                    if (response.all_complete) {
                        clearInterval(intervalId);
                    }
                }
            })
        }, 30000);
    }
}


function pageInfoTmdb(page, videoid) {
    let sort_type;
    let sort;
    if ($('.icon-sort-up').length > 0) {
        sort_type = $('.icon-sort-up').data('type');
        sort = 'ASC';
    } else if ($('.icon-sort-down').length > 0) {
        sort_type = $('.icon-sort-down').data('type');
        sort = 'DESC';
    }

    getInfoTmdb(videoid, $('#type_tmdb').val(), $('#search_title').val(), page, sort_type, sort);
}
function showSpinner() {
    $('.taskHandler').show();
}

function hideSpinner() {
    $('.taskHandler').hide();
}

function slideFormSection(){
    $('.formSection h4').off('click').on({
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
}

function getSubtitleList(video_id) {
    var result = '';
    $.post({
        url: baseurl + 'actions/subtitle_get_list.php',
        dataType: 'json',
        data: {
            video_id: video_id,
        },
        success: function (response) {
            result = response.data;
        }
    });
}

function editTitle(number, videoid) {
    $('table[data-id="'+videoid+'"]').find('.buttons-' + number).css('display', 'inline');
    $('table[data-id="'+videoid+'"]').find('.edit_sub_' + number).css('display', 'inline');
    $('table[data-id="'+videoid+'"]').find('.span_sub_' + number).hide();
}

function cancelEditTitle(number, videoid) {
    $('.buttons-' + number).hide();
    $('.edit_sub_' + number).hide();
    $('.span_sub_' + number).show();
}
function saveSubtitle(number, videoid) {
    showSpinner();
    $.ajax({
        url: baseurl+"actions/subtitle_edit.php",
        type: "POST",
        data: {title: $('table[data-id="'+videoid+'"]').find('.edit_sub_' + number).val(), videoid: videoid, number: number},
        dataType: 'json',
        success: function (result) {
            $('#subtitles_' + videoid).html(result['template']);
            hideSpinner();
            $('.close').click();
            $('#uploadMessage').parent().prepend(result['msg']);
        }
    });
}

function deleteSubtitle(number, videoid) {
    showSpinner();
    if (confirm_it(text_confirm_sub_file.replace('%s', number))) {
        $.ajax({
            url: baseurl+"actions/subtitle_delete.php",
            type: "POST",
            data: {number: number, videoid: videoid},
            dataType: 'json',
            success: function (result) {
                $('#subtitles_' + videoid).html(result['template']);
                $('.close').click();
                $('#uploadMessage').parent().prepend(result['msg']);
                hideSpinner();
            }
        });
    }
}