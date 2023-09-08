$(function () {
    $('#list_tags').tagit({
        singleField:true,
        fieldName:"tags",
        readOnly:true,
        singleFieldNode:$('#tags'),
        animate:false,
        caseSensitive:false
    });

    if (link_tags !== undefined && link_tags) {
        var labels = $('.tagit-label');
        labels.each(function () {
            $(this).parent().wrap('<a href="/search_result.php?query=' + $(this).html()+ '&type=tag"></a>');
        });
    }
})
