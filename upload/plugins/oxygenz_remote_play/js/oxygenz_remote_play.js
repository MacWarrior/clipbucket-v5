$( document ).ready(function() {
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
    console.log($('#remote_tags_video'));
    $("[id^=remote_tags]").each(function(elem){
        init_tags(this.id, available_tags,'#remote_list_'+this.name);
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
                if(data.error){
                    $('#uploadMessage').html(data.error).attr('class', 'alert alert-danger').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);
                    $('#oxygenz_remote_play_submit_form2').attr('disabled', false).html(oxygenz_remote_play_lang_submit_now);
                } else {
                    $('#uploadMessage').html(data.msg).attr('class', 'alert alert-success').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);

                    if(step === 'save'){
                        $('#oxygenz_remote_play_form').find('input[name="videokey"]').attr('disabled', false).val(data.videokey);
                        $('#oxygenz_remote_play_form').find('input[name="oxygenz_remote_play_file_url"]').attr('readonly', true);
                        step='update';
                    }

                    $('#oxygenz_remote_play_submit_form2').attr('disabled', false).html(oxygenz_remote_play_lang_submit_now);
                }
            },
            //error: function(){},
            //complete: function(){}
        });
    });
});