$(document).ready(function(){
    if( visual_editor_comments_enabled ){
        var editor = new toastui.Editor({
            el: document.querySelector('#comment_box_visual_editor'),
            initialEditType: 'wysiwyg',
            previewStyle: 'vertical',
            height: '200px',
            usageStatistics: false,
            toolbarItems: [
                ['bold', 'italic', 'strike'],
                ['ul', 'ol', 'task', 'indent', 'outdent'],
                ['table','link']
            ],
            language: 'ko',
            placeholder: visual_editor_comments_placeholder
        });
    }

    function get_the_comment(id,type_id,div)
    {
        $.post(page, {
                mode : 'get_comment',
                cid : id,
                type_id : type_id
            },
            function(data) {
                if(!data){
                    alert("No data");
                } else {
                    if (data.parent_id) {
                        $('.reply-box-' + data.parent_id).hide();
                        $('.comments-reply-' + data.parent_id).append(data.li_data).slideDown();
                        $('html, body').animate({
                            scrollTop: $('#reply-' + id).offset().top
                        }, 1000);
                        comment_transition('.reply-',id);
                    } else {
                        $(data.li_data).hide().prependTo('#comments-ul').slideDown("slow");
                    }
                }
                clear_comment_form();
            },'json');
    }
    function add_comment_js(form_id)
    {
        $('#add_comment_result').css('display','block');
        $('#add_comment_button').val(lang_loading);
        $('#add_comment_button').attr('disabled',true);
        $(".add-reply").attr('disabled',true);

        //First we will get all values of form_id and then serialize them
        //so we can forward details to ajax.php
        var formObjectData = $('#' + form_id).serialize() + '&mode=add_comment';
        $.post(page,formObjectData,
            function(data) {
                if(!data){
                    alert('No data');
                } else {
                    $('#add_comment_result').css('display','block');
                    if(data.err != '' && data.err != null) {
                        $('#comment_err_output').fadeIn();
                        $('#comment_err_output').html(data.err);
                        setTimeout(function(){
                            $('#comment_err_output').fadeOut();
                        }, 10000);

                        var str = data.err;
                        var string_finder = str.substring(0, 12);
                        if (string_finder != 'Mailer Error'){
                            clear_comment_form();
                        }
                    }
                    if(data.msg!='') {
                        $('#comment_box').val('');
                    }
                    if(data.cid) {
                        $('.no-comments').remove();
                        get_the_comment(data.cid,data.type_id,'#comments-ul');
                        var count = parseInt($('#comment_count').html());
                        $('#comment_count').html((count+1).toString());
                    }

                }
            },'json');
    }

    $('#add_comment_button').on('click',function(){
        if( visual_editor_comments_enabled ){
            $('#comment_box').val(editor.getMarkdown())
        }
        add_comment_js('comment_form');
    });
    $('#comment_box').keypress(function(e){
        if(e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();
            add_comment_js('comment_form');
        }
    });
});