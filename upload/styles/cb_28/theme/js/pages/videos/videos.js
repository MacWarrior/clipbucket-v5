$(document).ready(function(){
    $(".dropdown-menu > li > div > a").on("mouseover",function(e){
        let current=$(this).parent().next();

        $(this).parent().parent().parent().find(".sub-menu:visible").not(current).hide();
        current.toggle();
    });

    progressVideoCheck(ids_to_check_progress, 'videos');

   _cb.listener_favorite_only_remove('video');
});