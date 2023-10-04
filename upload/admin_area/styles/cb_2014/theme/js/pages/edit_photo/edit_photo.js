
$('#edit_photo_submit').on("click",function(e){
    e.preventDefault();
    $('#edit_photo').submit();
})

$(function () {
    init_tags('tags', available_tags);
});