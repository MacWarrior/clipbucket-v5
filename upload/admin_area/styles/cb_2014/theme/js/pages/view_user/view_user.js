$(document).ready(function(){
    init_tags('profile_tags', available_tags);

    $('[name="disabled_channel"]').on('change', function (e) {
        var inputs = $(this).parents('table').find('input, textarea').not('#disabled_channel');
        inputs.each( (i,e)=> $(e).prop('disabled', ($(this).val() === 'yes')))
    });

    if( visual_editor_comments_enabled ){
        Array.from(document.querySelectorAll('#comments .itemdiv .body .col-md-7 span')).forEach((comment,index) => {
            new toastui.Editor.factory({
                el: comment,
                viewer: true,
                usageStatistics: false,
                initialValue: comment.innerHTML
            });
        });
    }
});