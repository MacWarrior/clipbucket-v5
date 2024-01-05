var grabbed_json = 'nothing';

$(document).ready(function(){
    var uploadurl = '/actions/file_uploader.php';
    if(uploadScriptPath !== ''){
        uploadurl = uploadScriptPath;
    }

    var extensions = back_extensions;
    extensions = extensions.substring(0, extensions.length-1);

    $.get(theme+"/js/plupload/js/plupload.full.min.js", function(e){
        var uploader = new plupload.Uploader({
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
                    { title : 'Video files', extensions : extensions }
                ]
            }
        });

        function reFreshTabs(up)
        {
            // creating the selected files list
            var tabs = document.createElement('ul');
            tabs.id = 'selectedFilesList';
            tabs.className = 'nav nav-tabs';
            var li = false;
            var index = 1;
            var uploadForm = $('#updateVideoInfoForm.template').clone();
            var oneUploadForm = false;
            var uploadForms = [];
            plupload.each(up.files, function(file) {
                li = document.createElement('li');
                if(index === up.files.length){
                    li.className = 'active';
                }else{
                    li.className = '';
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
                    wrapperDiv.className = 'tab-pane active uploadFormContainer';
                } else {
                    wrapperDiv.className = 'tab-pane uploadFormContainer';
                }

                $(oneUploadForm).find(".cancel_button").attr('to_cancel',index);
                $(oneUploadForm).find("input[name='title']").val(file.data.title);
                $(oneUploadForm).find("textarea[name='description']").val(file.data.description);
                $(oneUploadForm).find("input[name='tags']").val(file.data.tags).attr('id', 'tags'+ index);
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

                var tagsList = document.createElement('ul');
                tagsList.id = 'list_tags_' + index;
                $(tagsList).insertAfter($(oneUploadForm).find("input[name='tags']"));
                var alert_shown = false;
                $(oneUploadForm).find('#list_tags_'+ index).tagit({
                    singleField:true,
                    readOnly:false,
                    singleFieldNode: $(oneUploadForm).find('#tags'+ index),
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

                if(file.data.broadcast === 'unlisted'){
                    $(oneUploadForm).find('#video_password').attr('disabled',false);
                } else if(file.data.broadcast === 'private') {
                    $(oneUploadForm).find('#video_users').attr('disabled',false);
                }

                $.each(file.data['category[]'],function(index, value){
                    $(oneUploadForm).find("input[name='category[]'][value='"+value+"']").prop('checked', true);
                });

                if( file.show_duration === true ){
                    $(oneUploadForm).find('#duration').removeClass('hidden').removeAttr('disabled');
                }

                if( file.percent === 100 ){
                    $(oneUploadForm).find('.saveVideoDetails').removeAttr('disabled');
                }

                wrapperDiv.appendChild(oneUploadForm);
                uploadForms.push(wrapperDiv);

                li.id = index++;
                li.appendChild(link);
                tabs.appendChild(li);
            });

            $('#files').html('').append(tabs);
            $('#allUploadForms').html('').append(uploadForms);

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

        uploader.bind('FilesRemoved', function(up) {
            reFreshTabs(up);
        });

        uploader.bind('FilesAdded', function(up, uploadedFiles) {
            $("#uploadMore").addClass("hidden");

            const filename = uploadedFiles[0].name;
            let filename_without_extension = filename.substring(0, filename.lastIndexOf('.'));
            if( filename_without_extension.length > max_video_title ){
                filename_without_extension = filename_without_extension.substring(0, max_video_title);
            }

            uploadedFiles[0].data = [];
            uploadedFiles[0].data.title = filename_without_extension;
            uploadedFiles[0].data.description = filename_without_extension;
            uploadedFiles[0].data.tags = '';
            uploadedFiles[0].data.country = default_country_iso2;
            uploadedFiles[0].data.location = '';
            uploadedFiles[0].data.datecreated = date_format_time;
            uploadedFiles[0].data.broadcast = '';
            uploadedFiles[0].data.video_password = '';
            uploadedFiles[0].data.video_users = '';
            uploadedFiles[0].data.allow_comments = 'yes';
            uploadedFiles[0].data.comment_voting = 'yes';
            uploadedFiles[0].data.allow_rating = 'yes';
            uploadedFiles[0].data.allow_embedding = 'yes';
            uploadedFiles[0].data['category[]'] = [get_default_cid];

            reFreshTabs(up);

            //function for real progress bar
            $.each( uploadedFiles, function( key, fileNow ) {
                var currentTitle = fileNow.name,
                    plFileId = fileNow.id;

                // appends progress bar along with title
                // this progress bar is later updated on realtime
                // via fileprogress event of pluploader

                $(".realProgressBars").append('<h5 class="realProgTitle_'+plFileId+'">'+currentTitle+'</h5><button class="clearfix cancel_button btn btn-danger" to_cancel="'+plFileId+'" style="float:right; margin-top: -8px; margin-left:10px;">Cancel Uploading</button><div class="progress"><div class="progress-bar progress-bar_'+plFileId+'" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%;"><span class="sr-only">70% Complete</span><span class="realProgText_'+plFileId+'">50% completed</span></div></div>');
            });
            //end function

            var index = 1;
            for (var i = 0; i < up.files.length; i++ ){
                if( up.files[i].file_name !== undefined ){
                    var hiddenField_fileName = document.createElement('input');
                    hiddenField_fileName.name = 'file_name';
                    hiddenField_fileName.type = 'hidden';
                    hiddenField_fileName.value = up.files[i].file_name;
                    $('#tab'+index+' form').append(hiddenField_fileName);
                }

                if( up.files[i].show_duration === true ){
                    $('#tab'+index+' #duration').removeClass('hidden').removeAttr('disabled');
                }

                if( up.files[i].percent < 100 ){
                    $('#tab'+index+' .saveVideoDetails').attr('disabled',true);
                }
                index++;
            }

            $('.formSection h4').on({
                click: function(e){
                    e.preventDefault();
                    if($(this).find('i').hasClass('glyphicon-chevron-down')){
                        $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                        $(this).next().toggleClass('hidden');
                    }else{
                        $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                        $(this).next().toggleClass('hidden');
                    }
                }
            });

            /*
            * Trigger element when "Cancel Uploading" button is clicked
            * stops uploading
            * hides uploading div
            */
            $(".cancel_button").on('click',function(e) {
                e.preventDefault();
                var toCancel = $(this).attr('to_cancel');
                var thecount = 0;
                $(this).attr('disabled',true);
                $(this).text('Canceled');
                $.each( uploadedFiles, function( iNow, currentFile ){
                    if (currentFile.id === toCancel) {
                        uploader.removeFile(uploadedFiles[thecount]);
                        $(this).unbind().remove();
                        $('.progress-bar_'+toCancel).addClass('progress-bar-danger');
                        $('.realProgText_'+toCancel).text('Canceled');
                        $("#uploadMessage").removeClass("hidden").html('Upload has been canceled').attr('class', 'alert alert-danger container');
                        setTimeout(function(){
                            $("#uploadMessage").addClass('hidden');
                        }, 5000);
                    }
                    thecount++;
                });
            });

            setTimeout(function(){
                $('#uploaderContainer').toggleClass('hidden');
                $('#uploadDataContainer').toggleClass('hidden');
                $('.uploadingProgressContainer').show();
                $('.allProgress').removeClass('hidden');
                uploader.start();
            }, 1000);
            // updating file title in the form
        });

        uploader.bind('BeforeUpload', function(){
            $('#fileUploadProgress').removeClass('hidden');
            $('.progress-container').removeClass('hidden');
        });

        /*
        This is the event handler for UploadProgress,
        It fires regularly after a certain amount of time when the the files are being uploaded
        */

        var filesUploaded = 0;

        uploader.bind('FileUploaded', function(up, fileDetails, response)
        {
            $('#overallProgress').css('width', ((100/up.files.length)*(++filesUploaded))+"%");
            $('#overallProgress').parents('.row').find('#uploadedFilesInfo').text('Inserted ' + (filesUploaded) + ' of ' + up.files.length);
            var serverResponse = $.parseJSON(response.response);

            var index = 1;
            plupload.each(up.files,function(file) {
                if( file.id === fileDetails.id ){
                    file.file_name = serverResponse.file_name;

                    var hiddenField_fileName = document.createElement('input');
                    hiddenField_fileName.name = 'file_name';
                    hiddenField_fileName.type = 'hidden';
                    hiddenField_fileName.value = serverResponse.file_name;
                    $('#tab'+index+' form').append(hiddenField_fileName);

                    if(serverResponse.extension === 'mp4' && stay_mp4 === 'yes' ){
                        file.show_duration = true;
                        $('#tab'+index+' #duration').removeClass('hidden').removeAttr('disabled');
                    } else {
                        file.show_duration = false;
                    }

                    $('#tab'+index+' .saveVideoDetails').removeAttr('disabled');
                }
                index++
            });

            /*
            Submit the form with all the video details and options
            to update the video information in the system
            */
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

        uploader.bind('UploadProgress', function(up, file) {
            // this the unique ID assigned to each file upload
            var pluploadFileId = file.id,
                filePercentage = file.percent;
            // update progress bar width
            $('.progress-bar_'+pluploadFileId).css('width',filePercentage+'%');
            //update progress bar text to show percentage
            $('.realProgText_'+pluploadFileId).text(filePercentage+'% Completed');
            // $("#progressNumber").text(file.percent + "%");
            // meaning file has completely uploaded
            if (filePercentage === 100) {
                // remove cancel button
                $(".cancel_button[to_cancel='" + pluploadFileId + "']").fadeOut('slow');
                // turn progress bar into green to show success
                $('.progress-bar_'+pluploadFileId).addClass('progress-bar-success');
            }
        });

        uploader.bind('UploadComplete', function(plupload, files){
            $("#fileUploadProgress").addClass('hidden');

            $("#uploadMore").removeClass('hidden');
            $(".uploadingProgressContainer").hide();
            uploader.refresh();
            $("#uploadMessage").html('File uploaded successfully').attr('class', 'alert alert-success container');
            setTimeout(function(){
                $("#uploadMessage").addClass('hidden');
            }, 5000);
        });

        uploader.bind('error', function(up, err) {
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

    });

    window.onbeforeunload = function() {
        if ($('.uploadingProgressContainer').is(':visible') === true) {
            return 'Uploading is in progress, are you sure you want to navigate away from this page?';
        }
        return null;
    };
});
