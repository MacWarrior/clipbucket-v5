$(function () {
    $('#list_tags').tagit({
        singleField:true,
        fieldName:"tags",
        readOnly:true,
        singleFieldNode:$('#tags'),
        animate:false,
    });
})
