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
});
