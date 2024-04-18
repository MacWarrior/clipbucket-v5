$(function () {
    $("[id^=tags]").each(function(elem){
        init_tags(this.id, available_tags, '#list_'+this.id);
    });

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

    $('#upload_thumbs').on('click', function (e) {
        e.preventDefault();
        var fd = new FormData();

        $.each($('#new_thumbs')[0].files, function(i, file) {
            fd.append('vid_thumb[]', file);
        });
        $.ajax(
            'upload_thumb.php?video=' + videoid
            , {
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: fd
                , success: function (data) {
                    // location.reload();
                }
            }
        )
    });
});
