
var link_type = "collections";
$(document).ready(function(){
    getAllComments('cl','{$c.collection_id}','{$c.last_commented}',1,'{$c.total_comments}','{$object_type}');
    var adHtml = $('.ad-holder').html();
    if(adHtml<1){
        $('.ad-holder').parent().remove();
        $('#photos').parent().removeClass('col-lg-10 col-md-10 col-sm-10');
        $('#photos').parent().addClass('clearfix col-lg-12 col-md-12 col-sm-12');
    }
});$(document).ready(function(){
    getAllComments('cl','{$c.collection_id}','{$c.last_commented}',1,'{$c.total_comments}','{$object_type}');
    var adHtml = $('.ad-holder').html();
    if(adHtml<1){
        $('.ad-holder').parent().remove();
        $('#photos').parent().removeClass('col-lg-10 col-md-10 col-sm-10');
        $('#photos').parent().addClass('clearfix col-lg-12 col-md-12 col-sm-12');
    }
});