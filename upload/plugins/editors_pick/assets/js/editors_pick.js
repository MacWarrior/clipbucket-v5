$(document).ready(function(){
    $('.editorpick-videos').find('.featured-video').click(function(){
        get_ep_video($(this).data('id-video'));
    });
});

function get_ep_video(vid)
{
    videojs($('#ep_video_container').find('video')[0]).dispose();
    $("#ep_video_container").html(loading);
    $.ajax({
        url : '/plugins/editors_pick/front/ajax.php',
        type : 'POST',
        dataType : 'json',
        timeout : 8000,
        data  : ({ vid : vid}),
        success : function(msg){
            if(!msg.data){
                alert("No data");
            } else {
                $("#ep_video_container").html(msg.data);
            }
        }
    });
}
