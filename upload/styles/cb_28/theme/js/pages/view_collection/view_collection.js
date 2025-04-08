var link_type = "collections";
$(document).ready(function(){
    getAllComments('cl',collection_id,last_commented,1,total_comments,object_type);
    var adHtml = $('.ad-holder').html();
    if(adHtml<1){
        $('.ad-holder').parent().remove();
        $('#photos').parent().removeClass('col-lg-10 col-md-10 col-sm-10');
        $('#photos').parent().addClass('clearfix col-lg-12 col-md-12 col-sm-12');
    }

    init_readonly_tags('tags', '#list_tags');
    progressVideoCheck(ids_to_check_progress, 'view_collection');

    $('.sort_dropdown').on('click', function(){
        showSpinner();
        var sort_id = $(this).data('sort');
        const url = new URL(window.location.href);
        const params = url.searchParams;
        params.set('sort_id', sort_id);
        url.search = params.toString();
        window.location = url.toString();
    });
});
