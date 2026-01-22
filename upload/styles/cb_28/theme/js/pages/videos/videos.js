$(document).ready(function(){
    $(".dropdown-menu > li > div > a").on("mouseover",function(e){
        let current=$(this).parent().next();

        $(this).parent().parent().parent().find(".sub-menu:visible").not(current).hide();
        current.toggle();
    });

    progressVideoCheck(ids_to_check_progress, 'videos');

    $('.manage_favorite').on('click', function(){
        const button = $(this);
        button.removeClass('glyphicon-heart').html(_cb.loading_img);
        _cb.remove_from_fav('video', button.data('id')).then(function (data) {
            button.remove();
        }).catch(function (err) {
            button.addClass('glyphicon-heart').html('');
        });
    });
});