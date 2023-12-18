(function(window){
    $(document).ready(function(){

        /* files uploading */
        $.get(theme + "/js/plupload/js/plupload.full.min.js", function(e){
            var files = [];
            var uploader = new plupload.Uploader({
                browse_button: 'selectFiles',
                runtimes : 'html5,flash,silverlight,html4',
                url : uploadScriptPath,
                dragdrop: true,
                drop_element: "dragDrop",
                max_file_size : max_upload_size + 'Mb',
                filters: {
                    mime_types : [
                        { title : "Image files", extensions : photo_extensions },
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
                var uploadForm = $('#photoForm form').clone();
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
                    oneUploadForm.className = 'updatePhotoInfoForm';
                    oneUploadForm.id = '';
                    var wrapperDiv = document.createElement('div');
                    wrapperDiv.id = 'tab'+index;

                    if(index === up.files.length){
                        wrapperDiv.className = 'tab-pane active uploadFormContainer';
                    } else {
                        wrapperDiv.className = 'tab-pane uploadFormContainer';
                    }

                    $(oneUploadForm).find(".cancel_button").attr('to_cancel',index);
                    $(oneUploadForm).find("input[name='photo_title']").val(file.data.photo_title);
                    $(oneUploadForm).find("textarea[name='photo_description']").val(file.data.photo_description);
                    $(oneUploadForm).find("input[name='photo_tags']").val(file.data.photo_tags).attr('id', 'tags'+ index);
                    $(oneUploadForm).find("select[name='collection_id']").val(file.data.collection_id).prop('disabled',true);
                    $(oneUploadForm).find("input[name='allow_comments'][value='"+file.data.allow_comments+"']").prop('disabled', true);
                    $(oneUploadForm).find("input[name='allow_embedding'][value='"+file.data.allow_embedding+"']").prop('checked', true);
                    $(oneUploadForm).find("input[name='allow_rating'][value='"+file.data.allow_rating+"']").prop('checked', true);
                    $(oneUploadForm).find("img").attr("src", file.data.photoThumb);

                    var hiddenField_photoId = document.createElement('input');
                    hiddenField_photoId.name = 'photo_id';
                    hiddenField_photoId.type = 'hidden';
                    hiddenField_photoId.value = file.data.photo_id;
                    $(oneUploadForm).append(hiddenField_photoId);

                    var tagsList = document.createElement('ul');
                    tagsList.id = 'list_tags_' + index;
                    $(tagsList).insertAfter($(oneUploadForm).find("input[name='photo_tags']"));

                    if( file.percent === 100 ){
                        $(oneUploadForm).find('.savePhotoDetails').removeAttr('disabled');
                    }

                    var alert_shown  = false;
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

                var collectionId;
                if ( collection_id ) {
                    collectionId = collection_id;
                } else {
                    collectionId = $("#SelectionDIV select").val();
                }

                $('.updatePhotoInfoForm').on({
                    submit: function(e){
                        e.preventDefault();
                        var data = $(this).serialize();
                        data += "&collection_id="+collectionId;
                        data += "&updatePhoto=yes";

                        $.ajax({
                            url : "/actions/photo_uploader.php",
                            type : "post",
                            data : data,
                            success: function (msg) {
                                msg = $.parseJSON(msg);
                                $("#uploadMessage").removeClass("hidden");
                                if (msg.error) {
                                    $('#uploadMessage').html(msg.error.val).attr('class', 'alert alert-danger container');
                                    $('html,body').animate({
                                        scrollTop: $("body").offset().top
                                    }, 'medium');
                                } else {
                                    $("#uploadMessage").html("Picture details are successfully updated").attr("class", "alert alert-success container");

                                    $('html,body').animate({
                                        scrollTop: $("body").offset().top
                                    }, 'medium');

                                    setTimeout(function () {
                                        $("#uploadMessage").addClass("hidden");
                                    }, 5000);
                                }
                            }
                        }).fail(function(err){
                            console.log(err);
                        });
                    }
                });
            }

            // initialize the uploader
            uploader.init();

            uploader.bind('FilesAdded', function(up, uploadedFiles) {
                for(var i = 0; i < uploadedFiles.length; i++){
                    files.push(uploadedFiles[i]);
                }

                uploadedFiles[0].data = [];
                uploadedFiles[0].data.photo_title = uploadedFiles[0].name;
                uploadedFiles[0].data.photo_description = uploadedFiles[0].name;
                uploadedFiles[0].data.photo_tags = '';
                uploadedFiles[0].data.collection_id = $('#collectionSelection').val();
                uploadedFiles[0].data.allow_comments = 'yes';
                uploadedFiles[0].data.allow_embedding = 'yes';
                uploadedFiles[0].data.allow_rating = 'yes';
                uploadedFiles[0].data.photoThumb = '';
                uploadedFiles[0].data.photo_id = 0;

                reFreshTabs(up);

                // functions added
                //function for real progress bar
                $.each( uploadedFiles, function( key, fileNow ) {
                    var currentTitle = fileNow.name,
                        plFileId = fileNow.id;

                    // appends progress bar along with title
                    // this progress bar is later updated on realtime
                    // via fileprogress event of pluploader

                    $(".realProgressBars").append('<h5 class="realProgTitle_'+plFileId+'">'+currentTitle+'</h5><button class="clearfix cancel_button btn btn-danger" to_cancel="'+plFileId+'" style="float:right; margin-top: -8px; margin-left:10px;">Cancel Uploading</button><div class="progress"><div class="progress-bar progress-bar_'+plFileId+'" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="sr-only">70% Complete</span><span class="realProgText_'+plFileId+'">50% completed</span></div></div>');
                });
                //real progress bar end function

                /*
                * Trigger element when "Cancel Uploading" button is clicked
                * stops uploading
                * hides uploading div
                */
                //function for cancel button
                (function() {
                    $(".cancel_button").on("click",function(e) {
                        e.preventDefault();
                        var toCancel = $(this).attr('to_cancel');
                        var thecount = 0;
                        $(this).attr('disabled',true);
                        $(this).text("Canceled");
                        $.each( uploadedFiles, function( iNow, currentFile ){
                            if (currentFile.id === toCancel) {
                                uploader.removeFile(uploadedFiles[thecount]);
                                $(this).unbind().remove();
                                $(".progress-bar_"+toCancel).addClass('progress-bar-danger');
                                $(".realProgText_"+toCancel).text("Canceled");
                                $('li#'+thecount).fadeOut('slow');
                                totalFiles = totalFiles - 1;
                            }
                            thecount++;
                        });
                    });
                })();
                //function for cancel button ended
                // function for UploadProgress

                uploader.bind('UploadProgress', function(up, file) {
                    // this the unique ID assigned to each file upload
                    var pluploadFileId = file.id,
                        filePercentage = file.percent;
                    // update progress bar width
                    $('.progress-bar_'+pluploadFileId).css("width",filePercentage+"%");
                    //update progress bar text to show percentage
                    $('.realProgText_'+pluploadFileId).text(filePercentage+"% Completed");
                    // $("#progressNumber").text(file.percent + "%");
                    // meaning file has completely uploaded
                    if (filePercentage == 100) {
                        // remove cancel button
                        $(".cancel_button[to_cancel='" + pluploadFileId + "']").fadeOut('slow');
                        // turn progress bar into green to show success
                        $('.progress-bar_'+pluploadFileId).addClass('progress-bar-success');
                    }
                });

                // function for UploadProgress ended
                // functions added ended

                setTimeout(function(){
                    $(".upload-area").addClass("hidden");
                    $(".form_header").addClass("hidden");
                    $("#uploadDataContainer").removeClass("hidden");
                    $(".uploadingProgressContainer").removeClass("hidden");
                    $("#uploadedFilesInfo").text("Uploaded 0 of " + files.length);
                    $(".allProgress").removeClass("hidden");
                    uploader.start();
                }, 1000);
                // updating file title in the form
                $("#allUploadForms").css("display", "block");
            });

            uploader.bind("BeforeUpload", function(){
                $("#fileUploadProgress").removeClass("hidden");
                $(".progress-container").removeClass("hidden");
            })

            var filesUploaded = 0;
            uploader.bind('UploadProgress', function(up, file) {
                $("#progressNumber").text(file.percent + "%");
                $("#videoNumber").text(file.name);
            });

            uploader.bind('FileUploaded', function(up, fileDetails, response){
                $("#overallProgress").css("width", ((100/files.length)*(++filesUploaded))+"%");
                $("#overallProgress").parents(".row").find("#uploadedFilesInfo").text("Uploaded " + (filesUploaded) + " of " + files.length);

                var serverResponse = $.parseJSON(response.response);

                var collectionId;
                if ( collection_id ) {
                    collectionId = collection_id;
                } else {
                    collectionId = $("#SelectionDIV select").val();
                }

                var index = 0;
                var current_index = 0;
                plupload.each(up.files,function(file) {
                    index++;
                    if( file.id === fileDetails.id ){
                        current_index = index;
                    }
                });

                $.ajax({
                    url : "/actions/photo_uploader.php",
                    type : "post",
                    data : {
                        insertPhoto : "yes"
                        ,title : fileDetails.name
                        ,file_name : serverResponse.file_name
                        ,collection_id: collectionId
                        ,ext: serverResponse.extension
                        ,photo_title : fileDetails.name
                        ,photo_description : fileDetails.name
                        ,photo_tags : ''
                    },
                    dataType: "JSON",
                    success: function(msg){
                        var hiddenField_photoId = document.createElement('input');
                        hiddenField_photoId.name = 'photo_id';
                        hiddenField_photoId.type = 'hidden';
                        hiddenField_photoId.value = msg.photoID;
                        $('#tab'+current_index+' form').append(hiddenField_photoId);
                        $('#tab'+current_index+' form').find('.edit-img-thumbnail > img').prop('src',msg.photoPreview);
                        $('#tab'+current_index+' .savePhotoDetails').removeAttr('disabled');

                        fileDetails.data.photoThumb = msg.photoPreview;
                        fileDetails.data.photo_id = msg.photoID;
                    }
                });
            });

            uploader.bind("UploadComplete", function(plupload, files){
                $("#fileUploadProgress").addClass("hidden");
                $("#uploadMore").removeClass("hidden");
                $(".uploadingProgressContainer").addClass("hidden");
                uploader.refresh();
                $("#uploadMessage").html("All Files are uploaded Successfully").attr("class", "alert alert-success container");
                setTimeout(function(){
                    $("#uploadMessage").addClass("hidden");
                }, 5000);
            });

            uploader.bind('error', function(up, err) {
                $("#uploadMessage").removeClass("hidden");
                if(err){
                    $("#uploadMessage").html(err.message).attr("class", "alert alert-danger container");
                }
                setTimeout(function(){
                    $("#uploadMessage").addClass("hidden");
                }, 8000);
            });

            $("#addNewCollection").on({
                click: function(e){
                    e.preventDefault();
                    var formData = $(this).parents("form").serialize();
                    formData += "&mode=add_collection";
                    var collectionName = $(this).parents("form").find("#collection_name").val();
                    $.ajax({
                        type: "post",
                        url: "/ajax.php",
                        data: formData,
                        success: function(msg){
                            msg = $.parseJSON(msg);
                            if(msg.err === null || msg.err === undefined){
                                var newCollectionElement = document.createElement('option');
                                newCollectionElement.value = parseInt(msg.id);
                                newCollectionElement.innerHTML = collectionName;
                                newCollectionElement.selected = true;
                                $("select[name='collection_id']").get(0).appendChild(newCollectionElement);
                                $("#collectionSelection").get(0).appendChild( newCollectionElement.cloneNode(true));

                                $("#uploadMessage").html(msg.msg).attr("class", "alert alert-success container").removeClass("hidden");

                                $("#CollectionDIV").toggle("fast");
                                $('.form_header').show();
                                $(".upload-area").show();
                                $('#collectionSelection').parent().show()
                                $('#SelectionDIV').find('.alert-danger').hide();

                                setTimeout(function(){
                                    $("#uploadMessage").addClass("hidden");
                                }, 5000);
                            }else if (msg.err == 'missing_table') {
                                $("#uploadMessage").html(msg.err).attr("class", "alert alert-danger container").removeClass("hidden");
                                setTimeout(function(){
                                    $("#uploadMessage").addClass("hidden");
                                }, 5000);
                            }else{
                                $("#uploadMessage").html(msg.err).attr("class", "alert alert-danger container").removeClass("hidden");
                                setTimeout(function(){
                                    $("#uploadMessage").addClass("hidden");
                                }, 5000);
                            }
                        }
                    });
                }
            });

            $("#createNewCollection").on({
                click: function(e){
                    e.preventDefault();
                    $('#CollectionDIV').toggle("fast").find('form')[0].reset();
                    $('.tagit li:not(.tagit-new)').remove();
                    $('.form_header').hide();
                    $(".upload-area").hide();
                }
            });

            $("#cancelAddCollection").on({
                click: function(e){
                    e.preventDefault();
                    $("#CollectionDIV").toggle("fast");
                    $('.form_header').show();
                    $(".upload-area").show();
                }
            });

            $("#selectedFilesList a").on({
                click: function(e){
                    e.preventDefault();
                    $(this).tab("show");
                }
            });

            $("#SelectionDIV select").on({
                change: function(e){
                    var collectionField = $("#collectionId");
                    if(collectionField){
                        $(collectionField).val(this.value);
                    }else{
                        var newField = document.createElement("input");
                        newField.type = "hidden";
                        newField.name = "collection_id";
                        newField.value = this.value;
                        $("#allUploadForms form").each(function(index, value){
                            $(value).get(0).appendChild(newField);
                        });
                    }
                }
            });

            $("#uploadMorePhotos").on({
                click: function(e){
                    e.preventDefault();
                    $(".upload-area").removeClass("hidden");
                    $(".form_header").removeClass("hidden");
                    $("#uploadDataContainer").addClass("hidden");
                }
            });
        });

        init_tags('collection_tags', available_collection_tags);
    });
})(window);