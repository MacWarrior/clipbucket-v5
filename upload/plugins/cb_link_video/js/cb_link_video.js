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

    $('#cb_link_video_submit_form1').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: cb_link_video_submit_form_url,
            type: 'POST',
            data: {
                step : 'check_link'
                ,cb_link_video_file_url : $('#cb_link_video_file_url').val()
            },
            dataType: 'json',
            beforeSend: function(){
                $('#cb_link_video_submit_form1').attr('disabled', true).html(cb_link_video_lang_checking);
            },
            success: function(data) {
                if(data.error){
                    $('#uploadMessage').html(data.error).attr('class', 'alert alert-danger').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);
                    $('#cb_link_video_submit_form1').attr('disabled', false).html(cb_link_video_lang_submit_now);
                } else {
                    $('#cb_link_video_form').find('input[name="title"]').val(data.filename);
                    $('#cb_link_video_form').find('textarea[name="description"]').val(data.filename);
                    $('#cb_link_video_form').find('input[name="tags"]').val(data.filename);

                    $('#cb_link_video_submit_form1').fadeOut(250);
                    $('#second-form').slideDown(1000);
                }
            },
            //error: function(){},
            //complete: function(){}
        });
    });

    var step = 'save';
    $('#cb_link_video_submit_form2').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: cb_link_video_submit_form_url,
            type: 'POST',
            data: {
                step : step
                ,form_data : $('#cb_link_video_form').serialize()
            },
            dataType: 'json',
            beforeSend: function(){
                $('#cb_link_video_submit_form2').attr('disabled', true).html(cb_link_video_lang_saving);
            },
            success: function(data) {
                if(data.error){
                    $('#uploadMessage').html(data.error).attr('class', 'alert alert-danger').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);
                    $('#cb_link_video_submit_form2').attr('disabled', false).html(cb_link_video_lang_submit_now);
                } else {
                    $('#uploadMessage').html(data.msg).attr('class', 'alert alert-success').show();
                    setTimeout(function(){
                        $('#uploadMessage').fadeOut(500);
                    }, 5000);

                    if(step === 'save'){
                        $('#cb_link_video_form').find('input[name="videokey"]').attr('disabled', false).val(data.videokey);
                        $('#cb_link_video_form').find('input[name="cb_link_video_file_url"]').attr('readonly', true);
                        step='update';
                    }

                    $('#cb_link_video_submit_form2').attr('disabled', false).html(cb_link_video_lang_submit_now);
                }
            },
            //error: function(){},
            //complete: function(){}
        });
    });
});