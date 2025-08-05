var page = baseurl+'actions/ajax.php';
var loading_img = "<img style='vertical-align:middle' src='"+imageurl+"/ajax-loader.gif'>";
var loading = loading_img+" Loading...";

function Confirm_Delete(delUrl) {
    if (confirm("Are you sure you want to delete")) {
        document.location = delUrl;
    }
}

function Confirm_Uninstall(delUrl) {
    if (confirm("Are you sure you want to uninstall this plugin ?")) {
        document.location = delUrl;
    }
}

function confirm_it(msg)
{
    var action = confirm(msg);
    if(action){
        return true;
    }
    return false;
}

function reloadImage(captcha_src,imgid){img = document.getElementById(imgid);img.src = captcha_src+'?'+Math.random();}

function load_more(limit,mode,inner_mode,append_id,attrb,cat_id,total)
{
    $.ajax({
        beforeSend:function (argument) {
            $('#'+inner_mode).html('loading');
        },
        type: 'POST',
        url: baseurl+'actions/ajax.php',
        data: {
            limit : limit,
            mode : mode,
            inner_mode : inner_mode,
            cat_id : cat_id,
            total : total
        },
        dataType: 'json',
        success: function(response) {
            if(response) {
                $('#' + append_id).append(response.template);
                $(attrb).attr({
                    "limit":(parseInt(response.count) + parseInt(response.total))
                });
            }
            if(response['limit_exceeds']==true) {
                attrb.css('display','none');
            }
            if(response=='limit_exceeds') {
                attrb.css('display','none');
            }

            $('#'+inner_mode).html('Load more...');
        }
    });
}

function randomString()
{
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    return randomstring;
}

var download = 0;
var count = 0;
var hasLoaded = false;

/**
 * Function used to delete any item with confirm message
 */
function delete_item(obj,id,msg,url)
{
    $('#'+obj+'-'+id).click(function () {
        if (confirm(msg)) {
            document.location = url;
        }
    });
}
function delete_video(obj,id,msg,url){ return delete_item(obj,id,msg,url); }


/**
 * Function used to load editor's pic video
 */
function get_video(type,div)
{
    $(div).css("display","block");
    $(div).html(loading);
    $(div).html(loading);
    $.post(
        page, {
            mode : type
        },
        function(data) {
            $(div).html(data);
        },'text'
    );
}

/**
 * functio used to get photos through ajax
 */
function getAjaxPhoto(type,div)
{
    $(div).css('display','block');
    var preservedHTML = $(div).html();
    $.ajax({
        url : page,
        type : 'POST',
        dataType : 'json',
        data : ({ mode : 'loadAjaxPhotos', 'photosType' : type }),
        beforeSend : function () {
            $(div).html(loading);
        },
        success : function (data) {
            if(data['failed']) {
                $(div).html(preservedHTML);
            }

            if(data['completed']) {
                $(div).html(data['photoBlocks']);
            }
        }
    })
}


function rating_over(msg,disable)
{
    if(disable!='disabled'){
        $("#rating_result_container").html(msg);
    }
}
function rating_out(msg,disable)
{
    if(disable!='disabled'){
        $("#rating_result_container").html(msg);
    }
}


function submit_share_form(form_id,type)
{
    $('#share_form_results').css('display','block');
    $('#share_form_results').html(loading);
    $.post(page, {
            mode : 'share_object',
            type : type,
            users : $("#ShareUsers").val(),
            message : $("#message").val(),
            id : $("#objectid").val()
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                $('#share_form_results').html(data);
            }
        },'text'
    );
}



function flag_object(form_id,id,type)
{
    $("#flag_form_result").css('display','block');
    $("#flag_form_result").html(loading);
    $.post(page, {
            mode : 'flag_object',
            type : type,
            flag_type : $("#"+form_id+" select option:selected").val(),
            id : id
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                $('#flag_form_result').css('display','block');
                $('#flag_form_result').html(data);
            }
        },'text');
}

function slide_up_watch_video(nodiv)
{
    if($('.video_action_result_boxes '+nodiv).css("display")!="block"){
        $('.video_action_result_boxes > *').slideUp();
    }
}

function add_to_fav(type,id)
{
    $("#video_action_result_cont").css('display','block');
    $("#video_action_result_cont").html(loading);

    $.post(page, {
            mode : 'add_to_fav',
            type : type,
            id : id
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                $('#video_action_result_cont').css('display','block');
                $('#video_action_result_cont').html(data);
            }
        },'text'
    );
}


function subscriber(user,type,result_cont)
{
    $('#'+result_cont).css('display','block');
    $('#'+result_cont).html(loading);

    $.post(page, {
            mode : type,
            subscribe_to : user
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                $('#'+result_cont).css('display','none');
                $('#'+result_cont).html(data);

                $('#result_cont').html(data);
                $('#result_cont').show(0).delay(3000).fadeOut('slow');
            }
        },'text'
    );
}

function add_friend(uid,result_cont)
{
    $("#"+result_cont).css('display','block');
    $("#"+result_cont).html(loading);

    $.post(page, {
            mode : 'add_friend',
            uid : uid
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                $('#result_cont').append(data);
                $('#result_cont').show(0).delay(3000).fadeOut('slow');
            }
        },'text'
    );
}

function block_user(user,result_cont)
{
    $('#'+result_cont).css('display','block');
    $('#'+result_cont).html(loading);

    $.post(page, {
            mode : 'ban_user',
            user : user
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                $('#'+result_cont).css('display','block');
                $('#'+result_cont).html(data);
            }
        },'text'
    );
}

function delete_comment(cid)
{
    $.post(page, {
            mode : 'delete_comment',
            cid : cid
        },
        function(data) {
            if(!data){
                alert('No data');
            } else {
                if(data.msg) {
                    if (data.nb === undefined) {
                        data.nb = 1;
                    }
                    $(".reply-"+cid).fadeOut('slow');
                    $("#comment_"+cid).fadeOut('slow');
                    $("#comment_msg_output").html(data.msg+' !');
                    $("#comment_msg_output").fadeIn('slow');
                    var count = parseInt($('#comment_count').html());
                    $('#comment_count').html((count- data.nb).toString());
                    setTimeout(function(){
                        $('#comment_msg_output').fadeOut();
                        $("#comment_"+cid).remove();
                    }, 3000);
                }
                if(data.err){
                    alert(data.err);
                }
            }
        },'json'
    );
}

function get_group_info(Div,li)
{
    if( $(Div).css('display') == 'none') {
        $('#group_info_cont > div').slideUp();
        $('#group_info_cont '+Div).slideDown();
        $('.group_detail_tabs .selected').removeClass('selected');
        $(li).addClass('selected');
    }
}

var current_menu = "";
function show_menu(menu,load_from_hash)
{
    if(window.location.hash && load_from_hash) {
        var thehash = window.location.hash;
        show_menu(thehash.substr(9),false);
        return false;
    }
    window.location.hash = 'current_'+menu;
    if(current_menu!=menu){
        hide_menu();
    }
    $("#"+menu).show();
    current_menu = menu;
    $("."+menu).addClass('selected');
}

function hide_menu()
{
    if(current_menu!='') {
        $('#'+current_menu).hide();
        $('.'+current_menu).removeClass('selected');
        return true;
    }
}

/**
 * Function autplay playlist
 */
function swap_auto_play()
{
    if($.cookie('auto_play_playlist') == 'true') {
        set_cookie_secure('auto_play_playlist','false');
        window.location = document.location;
        $('#ap_status').html('off');
    } else {
        set_cookie_secure('auto_play_playlist','true');
        window.location = document.location;
        $('#ap_status').html('on');
    }
}

function collection_actions(form,mode,objID,result_con,type,cid)
{
    $(result_con).css('display','block');
    $(result_con).html(loading);
    switch(mode) {
        case 'add_new_item':
            const value = $('#'+form+' #collection').val();
            if (!value || value =="" || value ==0) {
                 $(result_con).html('No Data returned');
                 return false;
            }
            $.post(baseurl+'actions/add_to_collection.php', {
                mode: mode,
                cid: value,
                obj_id: objID,
                type: type
            },
            function(data) {
                if(!data){
                    alert('No Data returned');
                } else {
                    if(data.msg){
                        $(result_con).html(data.msg);
                        $(result_con).find('.container').css({
                            'maxWidth' : '100%'
                        });
                    }
                }
            },'json');
            break;

        case 'remove_collection_item':
            $('#'+form).hide();
            $.post(page, {
                mode: mode,
                obj_id: objID,
                type: type,
                cid: cid
            },
            function(data) {
                if(!data) {
                    alert('No Data Returned');
                    $(result_con+'_'+objID).hide();
                    $('#'+form).show();
                } else {
                    if(data.err) {
                        alert(data.err);
                        $(result_con+'_'+objID).hide();
                        $('#'+form+objID).show();
                    }

                    if(data.msg) {
                        $(result_con).html(data.msg);
                        $('#'+form+'_'+objID).slideUp(350);
                    }
                }
            },'json');
            break;
    }
}

// Simple function to open url with javascript
function openURL(url) {
    document.location = url;
}

function get_item(obj,ci_id,cid,type,direction)
{
    var btn_text = $(obj).html();
    $(obj).html(loading);

    $.post(page, {
        mode : 'get_item',
        ci_id: ci_id,
        cid : cid,
        type: type,
        direction: direction
    },
    function(data) {
        if(!data) {
            alert('No '+type+' returned');
            $(obj).text(btn_text);
        } else {
            var jsArray = new Array(type,data['cid'],data['key']);
            construct_url(jsArray);
            $('#collectionItemView').html(data['content']);
        }
    },'json')
}

function construct_url(jsArr)
{
    var url;
    if(Seo == 'yes') {
        url = '#!/item/'+jsArr[0]+'/'+jsArr[1]+'/'+jsArr[2];
        window.location.hash = url
    } else {
        url	= '#!?item='+jsArr[2]+'&type='+jsArr[0]+'&collection='+jsArr[1];
        window.location.hash = url
    }
}

function onReload_item()
{
    var comURL, regEX;
    if(window.location.hash) {
        comURL = window.location.href;
        if(Seo == 'yes') {
            regEX = RegExp('\/item.+#!');
            if(regEX.test(comURL)) {
                comURL = comURL.replace(regEX,'');
                window.location.href = comURL;
            }
        } else {
            regEX = RegExp('\\\?item.+#!');
            if(regEX.test(comURL)) {
                comURL = comURL.replace(regEX,'')
                window.location.href = comURL;
            }
        }
    }
}

function pagination(object,cid,type,pageNumber)
{
    var obj = $(object), objID = obj.id,
        paginationParent = obj.parent(), paginationParentID, paginationInnerHTML = obj.html();

    if(paginationParent.attr('id')){
        paginationParentID = parent.attr('id')
    } else {
        paginationParent.attr('id','loadMoreParent'); paginationParentID = paginationParent.attr('id');
    }

    newCall =
        $.ajax({
            url: page,
            type: 'post',
            dataType: 'json',
            data: {
                mode: 'moreItems',
                page:pageNumber,
                cid: cid,
                type: type
            },
            beforeSend: function() {
                obj.removeAttr('onClick');
                obj.html(loading)
            },
            success : function(data) {
                if(data['error']) {
                    if(object.tagName == 'BUTTON'){
                        obj.attr('disabled','disabled');
                    }
                    obj.removeAttr('onClick'); obj.html('No more '+type);
                } else {
                    $('#collectionItemsList').append(data['content']);
                    $('#NewPagination').html(data['pagination']);
                    obj.html(paginationInnerHTML);
                }
            }
        });
}
var collectionID;
function ajax_add_collection(obj)
{
    var formID = obj.form.id, Form = $('#'+formID),
        This = $(obj), AjaxCall, ButtonHTML = This.html(),
        Result = $('#CollectionResult');
    AjaxCall =
    $.ajax({
        url: page,
        type: "post",
        dataType: "json",
        data: "mode=add_collection&"+Form.serialize(),
        beforeSend: function() {
            if(Result.css('display') == 'block') {
                Result.slideUp('fast');
            }
            This.attr('disabled','disabled');
            This.html(loading)
        },
        success: function(data) {
            if(data.msg) {
                $('#CollectionDIV').slideUp('fast');
                Result.html(data['msg']).slideDown('fast');
                collectionID = data['id'];
            } else {
                Result.html(data['err']).slideDown('fast');
                This.removeAttr('disabled'); This.html(ButtonHTML);
            }
        }
    });
}



function getDetails(obj)
{
    var forms = getInputs(obj), ParamArray = new Array(forms.length);

    $.each(forms,function(index,form) {
        query = $('#'+form.id+' *').serialize();
        query += '&mode=ajaxPhotos';
        ParamArray[index] = query;
    })

    return ParamArray;
}

function getName(File)
{
    var url = File;
    var filename = url.substring(url.lastIndexOf('/')+1);
    return filename;
}

function viewRatings(object,pid)
{
    var obj = $(object), innerHTML = obj.html();
    if(document.getElementById('RatingStatContainer')){
        $("#RatingStatContainer").toggle();
    } else {
        loadAjax =
            $.ajax({
                url:page,
                type: "post",
                dataType: "text",
                data: { mode:"viewPhotoRating", photoid:pid },
                beforeSend: function() { obj.html(loading); },
                success:function(data) {
                    obj.html(innerHTML);
                    if(data) {
                        $("<div />").attr('id','RatingStatContainer')
                            .addClass('clearfix')
                            .css({
                                "padding" : "8px",
                                "font" : "normal 11px Tahoma",
                                "border" : "1px solid #ccc",
                                "backgroundColor" : "#FFF"
                            }).html(data).fadeIn(350).insertAfter(obj);
                    } else {
                        obj.removeAttr('onclick');
                        alert("Photo has not recieved any rating yet.");
                    }
                }
            });
    }
}

function showAdvanceSearch(simple,advance,expandClass,collapseClass)
{
    var simpleObj = $("#"+simple); var advanceObj = $("#"+advance);
    var	value = $('#SearchType').val();
    simpleObj.toggle();
    advanceObj.toggle();
    if(advanceObj.css('display') == 'block'){
        advanceObj.children().hide().filter('#'+value).show();
    }
    $('.'+expandClass).toggleClass(collapseClass);
}

function toggleCategory(object,perPage)
{
    var obj = $(object),
        child = obj.next();

    if(child.is(":visible")) {
        child.slideUp(350);
        obj.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    } else {
        child.slideDown(350);
        obj.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    }
}

function loadObject(currentDOM,type,objID,container)
{
    var object = new Array(4);
    object['this'] = currentDOM, object['type'] = type,
        object['objID'] = objID, object['container'] = container;

    var obj = $(object['this']);

    obj.parent().css('position','relative');

    $.ajax({
        url : page,
        type : 'POST',
        dataType : 'json',
        data  : ({
            mode : 'channelFeatured',
            contentType : object['type'],
            objID : object['objID']
        }),
        beforeSend : function() {
            obj.find('img').animate({ opacity : .5 });
            $('#'+object['container']).animate({ opacity : .5 });
        },
        success : function(data) {
            if(data['error']) {
                obj.find('img').animate({ opacity : 1 });
                $("#"+object['container']).animate({ opacity : 1 });
                alert(data['error']);
            } else {
                obj.parent().children('.selected').removeClass('selected');
                obj.addClass('selected');
                obj.find('img').animate({ opacity : 1 });
                $('#'+object['container']).html(data['data']);
                $('#'+object['container']).animate({ opacity : 1 });
            }
        }
    });
}

var comments_voting = 'no';
function getComments(type,type_id,last_update,pageNum,total,object_type,admin)
{
    $('#comments').html("<div style='padding:5px 0px;'>"+loading+"</div>");
    $.ajax({
        type: 'POST',
        url: page,
        data:  {
            mode:'getComments',
            page:pageNum,
            type:type,
            type_id:type_id,
            object_type : object_type,
            last_update : last_update,
            total_comments : total,
            comments_voting : comments_voting,
            admin : admin
        },
        success: function(data) {
            $('#comments').hide();
            $('#comments').html(data);
            $('#comments').fadeIn('slow');
        },
        dataType: 'text'
    });
}

function getAllComments(type,type_id,last_update,pageNum,total,object_type,admin){
    $('#userCommentsList').html("<div style='padding:5px 0px;'>"+loading+"</div>");
    $.ajax({
        type: 'POST',
        url: page,
        data:  {
            mode:'getComments',
            page:pageNum,
            type:type,
            type_id:type_id,
            object_type : object_type,
            last_update : last_update,
            total_comments : total,
            comments_voting : comments_voting,
            admin : admin
        },
        success: function(comments){
            $("#userCommentsList").html(comments);
            if( visual_editor_comments_enabled ){
                Array.from(document.querySelectorAll('#userCommentsList .commented-txt p')).forEach((comment,index) =>
                {
                    new toastui.Editor.factory({
                        el: comment,
                        viewer: true,
                        usageStatistics: false,
                        initialValue: comment.innerHTML
                    });
                });
            }
        },
        dataType: 'text'
    });
}

function checkUncheckAll(theElement) {
    let theForm = theElement.form
        , z = 0;

    console.log(theElement.form);
    for(z=0; z<theForm.length;z++){
        if(theForm[z].type === 'checkbox' && theForm[z].name !== 'checkall'){
            theForm[z].checked = theElement.checked;
        }
    }
}

/**
 * Function used to rate object
 */
function rate(id,rating,type)
{
    var page = baseurl+'actions/ajax.php';
    $.post(page, {
        mode : 'rating',
        id:id,
        rating:rating,
        type:type
    },
    function(data) {
        if(!data){
            alert('No data');
        } else {
            $("#rating_container").html(data);
        }
    },'text');
}

function setPageHash(Page)
{
    // Removing baseurl
    var hashPart = Page.replace(baseurl,"");
    window.location.hash = "#!"+hashPart;
}

function callURLParser()
{
    var expression = /(\#![/a-zA-Z0-9=\.\&\-\_\?]*)/g,
        location = window.location.href,
        returned = location.match(expression),
        lastVisited;
    if(returned) {
        lastVisited = returned[returned.length - 1];
        if(lastVisited){
            window.location.href = lastVisited.replace("#!",'');
        }
    }
}

function comment_transition(div_id,id)
{
    $(div_id + id).addClass('border-transition');
    setTimeout(function(){$(div_id + id).removeClass('border-transition'); }, 3000);
}

function isValidEmail(email) {
    if (email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
        return email;
    }
    return false;
}

function set_cookie_secure(name, value){
    if (location.protocol !== 'https:') {
        document.cookie=name + "=" + value +";path=/;samesite=strict;";
    } else {
        document.cookie=name + "=" + value +";secure;path=/;samesite=strict;";
    }
}

function unset_cookie(name){
    document.cookie=name + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/;samesite=strict;";
}

function age_disclaimer(accept) {
    if ( accept) {
        $('#disclaimer').hide();
        $('#container').removeClass('blur');
        set_cookie_secure('age_restrict','checked');
    } else {
        window.location = 'https://www.google.com';
    }
}

function progressVideoCheck(ids_to_check_progress, displayType, intervalName) {
    if (typeof intervalName === 'undefined') {
        intervalName = 'intervalId';
    }
    if (ids_to_check_progress && ids_to_check_progress.length > 0) {
        window[intervalName] = setInterval(function () {
            $.post({
                url: baseurl+'actions/progress_video.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress,
                    output: displayType
                },
                success: function (response) {
                    let data = response.data;

                    if( data.videos === undefined ){
                        clearInterval(window[intervalName]);
                        return;
                    }

                    data.videos.forEach(function (video) {
                        if (video.status.toLowerCase() === 'processing') {
                            //update %
                            var process_div = $('.processing[data-id="' + video.videoid + '"]');
                            //if process don't exist : get thumb + process div
                            if (process_div.length === 0) {
                                $('.item-video[data-id="'+video.videoid+'"]').html(video.html);
                            } else {
                                process_div.find('span').html(video.percent + '%');
                            }
                        } else {
                            $('.item-video[data-id="'+video.videoid+'"]').html(video.html);
                            if (displayType === 'view_channel_player' && data.player !== undefined && data.player.id === video.videoid) {
                                $('#cb_player').html(data.player.html);
                            }
                            //init listeners
                            if ( displayType === 'videos') {
                                AddingListenerModernThumbVideo();
                            } else if(displayType.indexOf('home') !== -1) {
                                AddingListenerModernThumbVideo();
                                AddingListenerModernThumbVideoPopinView();
                            }
                        }
                    });

                    if (response.all_complete) {
                        clearInterval(window[intervalName]);

                    }
                }
            })
        }, 60000);
    }
}
function showSpinner() {
    $('.taskHandler').show();
}

function hideSpinner() {
    $('.taskHandler').hide();
}

function addErrClass(obj, msg, override = false, scroll = true, tclass = false) {
    $(obj).closest('.form-group').removeClass('success-ind');
    if (tclass !== false) {
        $(obj).closest('.form-group').removeClass('invalid-error');
        $(obj).closest('.form-group').addClass(tclass);
    } else {
        $(obj).closest('.form-group').removeClass('warning-ind');
        $(obj).closest('.form-group').addClass('invalid-error');
    }
    if (override === true) {
        $(obj).next('span').remove();
    }
    $('<span class="help-block">'+msg+"</span>").insertAfter(obj);
    if (scroll === true) {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
}

function getModalUploadSubtitle(video_id) {
    showSpinner();
    $.ajax({
        url: "actions/subtitle_popin_upload.php",
        type: "POST",
        data: {videoid: video_id },
        dataType: 'json',
        success: function (result) {
            hideSpinner();
            var modal = $('#myModal');
            modal.html(result['template']);
            modal.modal();
            $('.manage-page').prepend(result['msg']);
        }
    });
}
