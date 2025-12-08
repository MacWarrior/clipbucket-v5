var visual_editors = {};

function get_the_comment(id,type_id,div) {
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
                    if( visual_editor_comments_enabled ){
                        let elements = document.querySelectorAll('.comments-reply-' + data.parent_id + ' .commented-txt p');
                        let last_reply = elements[elements.length - 1];
                        new toastui.Editor.factory({
                            el: last_reply,
                            viewer: true,
                            usageStatistics: false,
                            initialValue: last_reply.innerHTML
                        });
                    }

                    $('html, body').animate({
                        scrollTop: $('#reply-' + id).offset().top
                    }, 1000);
                    comment_transition('.reply-',id);
                } else {
                    $(data.li_data).hide().prependTo(div);

                    if( visual_editor_comments_enabled ){
                        let new_comment = document.querySelectorAll(div + ' p')[0];

                        new toastui.Editor.factory({
                            el: new_comment,
                            viewer: true,
                            usageStatistics: false,
                            initialValue: new_comment.innerHTML
                        });
                    }

                    $(div).children().first().slideDown("slow");
                }
            }
            clear_comment_form();
        },'json');
}

function add_comment_js(form_id) {
    $('#add_comment_result').css('display','block');
    $('#add_comment_button').val(lang_loading);
    $('#add_comment_button').attr('disabled',true);
    $('.add-reply').attr('disabled',true);

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
                    if( visual_editor_comments_enabled ){
                        visual_editors[form_id].reset();
                    } else {
                        $('#comment_box').val('');
                    }
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

function clear_comment_form() {
    $('#add_comment_button').val(lang_add_comment);
    $('#add_comment_button').attr('disabled',false);
    $('.add-reply').attr('disabled',false);
}

function init_visual_editor(selector, placeholder){
    if ($(selector).length === 0){
        return false;
    }
    return new toastui.Editor({
        el: document.querySelector(selector),
        initialEditType: 'wysiwyg',
        previewStyle: 'vertical',
        usageStatistics: false,
        toolbarItems: [
            ['bold', 'italic', 'strike'],
            ['ul', 'ol', 'indent', 'outdent'],
            ['link']
        ],
        language: current_language,
        placeholder: placeholder,
        theme: default_theme
    });
}

function reply_box(cid,type,type_id) {
    let replying_to_user = $(document).find('#says_'+cid).attr('speaker');
    let lang_reply_to_user = lang_reply_to + ' ' + replying_to_user + '...';

    let html = '<form name="reply_form" method="post" id="reply_form_' + cid + '" onsubmit="return false;">';
    html += '<input type="hidden" name="reply_to" id="reply_to" value="' + cid +'">';
    html += '<input type="hidden" name="obj_id" id="obj_id" value="' + type_id + '"> ';
    html += '<input type="hidden" name="type" value="' + type + '" />';

    if( visual_editor_comments_enabled ){
        html += '<input type="hidden" name="comment" id="reply_comment_' + cid + '"/>';
        html += '<div class="form-group clearfix"><div id="reply_box_' + cid + '"></div></div>';
    } else {
        html += '<div class="textarea-comment clearfix">';
        html += '<textarea name="comment" id="reply_box_' + cid + '" class="form-control" placeholder="' + lang_reply_to_user + '"></textarea>';
        html += '<i class="remove-' + cid + ' remove-icon" onclick="remove_reply_box(' + cid + ')">';
        html += '<span style="color:#006dcc;cursor:pointer">';
        html += '<strong class="icon-close"></strong>';
        html += '</span>';
        html += '</i>';
        html += '</div>';
    }

    html += '<input type="button" name="add_reply" id="add_reply_button_' + cid + '" class="btn btn-primary pull-right add-reply" value="' + lang_reply + '">';

    if( visual_editor_comments_enabled ) {
        html += '<input type="button" class="btn btn-primary pull-right" onclick="remove_reply_box(\'' + cid + '\')" value="' + lang['cancel'] + '">';
    }

    $('.reply-box-' + cid).html(html);

    if( visual_editor_comments_enabled ) {
        visual_editors['reply_form_' + cid] = init_visual_editor('#reply_box_' + cid, lang_reply_to_user);
    } else {
        $('#reply_box_' + cid).focus();
    }

    $('#add_reply_button_' + cid).on('click',function(){
        if( visual_editor_comments_enabled ){
            $('#reply_comment_' + cid).val(visual_editors['reply_form_' + cid].getMarkdown())
        }
        add_comment_js('reply_form_' + cid);
    });

    $('.reply-box-' + cid).slideDown("slow");
}

function remove_reply_box(cid){
    $('.reply-box-' + cid).slideUp('slow').children().remove();
}

function show_replies(id){
    $('.more-comments-' + id).show();
}

function spam_comment(cid) {
    $.post(page, {
            mode : 'spam_comment',
            cid : cid,
        },
        function(data) {
            if(!data){
                alert('No data');
            }else {
                if(data.msg) {
                    $('#comment_'+cid).hide();
                    $('#spam_comment_'+cid).fadeIn('slow');
                }
                if(data.err) {
                    $('#comment_err_output').fadeIn('slow')
                    $('#comment_err_output').html(data.err);
                }
            }
        },'json');
}

function to_reply(cid) {
    $('#reply_to').val(cid);
    window.location = "#reply";
    $('#reply_to_img').fadeIn(1500);

    setTimeout(function(){
        $('#reply_to_img').fadeOut(500);
    }, 7000);
}

$(document).ready(function(){
    if( visual_editor_comments_enabled ){
        visual_editors['comment_form'] = init_visual_editor('#comment_box_visual_editor', visual_editor_comments_placeholder);
    }

    $('#add_comment_button').on('click',function(){
        if( visual_editor_comments_enabled ){
            $('#comment_box').val(visual_editors['comment_form'].getMarkdown())
        }
        add_comment_js('comment_form');
    });

    if( !visual_editor_comments_enabled ) {
        $('#comment_box').keypress(function (e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                add_comment_js('comment_form');
            }
        });
    }

    document.addEventListener('postThemeSwitch', function(e) {
        if( e.detail.theme === 'light' ){
            document.querySelectorAll('.toastui-editor-defaultUI.toastui-editor-dark').forEach(el => {
                el.classList.remove('toastui-editor-dark');
            });
        } else {
            document.querySelectorAll('.toastui-editor-defaultUI').forEach(el => {
                if (!el.classList.contains('toastui-editor-dark')) {
                    el.classList.add('toastui-editor-dark');
                }
            });
            if (!document.querySelector(`link[href="${toastui_editor_theme_dark_url}"]`)) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = toastui_editor_theme_dark_url;
                link.type = 'text/css';
                document.head.appendChild(link);
            }
        }
    });
});