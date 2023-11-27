function regenerateThumbs(videoid) {
    $.ajax({
        url: "/actions/regenerate_thumbs.php",
        type: "post",
        data: {videoid: videoid, origin: 'upload_thumb'},
        dataType: 'json',
        beforeSend: function(){
            showSpinner();
        },
        success: function(response){
            $('#thumb_list').html(response['template']);
            $('.page-content').prepend(response['msg']);
            hideSpinner();
        }
    });
}

function delete_thumb(videoid, num) {
    $.ajax({
        url: "/actions/delete_thumbs.php",
        type: "post",
        dataType: 'json',
        data: {videoid: videoid, num: num}
    }).done(function (result) {
        $('#thumb_list').html(result['template']);
    }).always(function (result) {
        $('.page-content').prepend(result['msg']);
    });
}
