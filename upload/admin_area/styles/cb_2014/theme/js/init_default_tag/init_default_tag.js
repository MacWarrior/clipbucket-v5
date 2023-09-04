$(function () {
    $('#list_tags').tagit({
        singleField:true,
        fieldName:"tags",
        readOnly:false,
        singleFieldNode:$('#tags'),
        animate:true,
        caseSensitive:false
    });
})
